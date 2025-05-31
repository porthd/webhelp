<?php

declare(strict_types=1);

namespace Porthd\Webhelp\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class XlfStatisticsCommand extends Command
{
    protected static $defaultName = 'extension:xlf-statistics';

    protected function configure(): void
    {
        $this
            ->setDescription('Erzeugt eine Statistik über XLF-Key-Nutzung im Startordner.')
            ->addArgument('path', InputArgument::REQUIRED, 'Pfad zum Startordner')
            ->addOption(
                'extensionlist',
                null,
                InputOption::VALUE_OPTIONAL,
                'Kommaseparierte Liste von zu analysierenden Dateiendungen',
                'html,htm,php,js,txt,typoscript,tsconfig,flex,t3s,t3c'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        set_time_limit(1800); // 30 Minuten

        $startPath = rtrim($input->getArgument('path'), '/');
        $extensionList = array_map('trim', explode(',', $input->getOption('extensionlist')));

        $xlfFiles = $this->collectXlfFiles($startPath);
        [$keyData, $languages] = $this->analyzeXlfFiles($xlfFiles);
        $this->analyzeKeyUsage($keyData, $startPath, $extensionList);
        $this->writeCsv($keyData, $languages, $startPath, $extensionList);

        $output->writeln('<info>CSV-Statistik erfolgreich erstellt.</info>');
        return Command::SUCCESS;
    }

    private function collectXlfFiles(string $path): array
    {
        $files = [];
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

        foreach ($iterator as $file) {
            if ($file->isFile() && strtolower($file->getExtension()) === 'xlf') {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }

    private function analyzeXlfFiles(array $xlfFiles): array
    {
        $data = [];
        $languages = [];

        foreach ($xlfFiles as $filePath) {
            $basename = basename($filePath);
            preg_match('/^(?:(\w{2})\.)?(.*)\.xlf$/', $basename, $matches);
            $language = $matches[1] ?? 'default';
            $baseName = $matches[2] ?? $basename;

            if (!in_array($language, $languages, true)) {
                $languages[] = $language;
            }

            $xml = @simplexml_load_file($filePath);
            if (!$xml || !isset($xml->file->body->{'trans-unit'})) {
                continue;
            }

            foreach ($xml->file->body->{'trans-unit'} as $unit) {
                $key = (string)$unit['id'];
                if ($key === '') {
                    continue;
                }

                $data[$baseName][$key]['path'] = $filePath;
                if (!isset($data[$baseName][$key]['xlf'][$language])) {
                    $data[$baseName][$key]['xlf'][$language] = 0;
                }

                $data[$baseName][$key]['xlf'][$language]++;
            }
        }

        return [$data, $languages];
    }

    private function analyzeKeyUsage(array &$data, string $path, array $extensions): void
    {
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

        foreach ($iterator as $file) {
            if (!$file->isFile()) {
                continue;
            }

            $ext = strtolower($file->getExtension());
            if ($ext === 'xlf') {
                continue;
            }

            $content = file_get_contents($file->getPathname());

            foreach ($data as $baseName => &$keys) {
                foreach ($keys as $key => &$details) {
                    if (strpos($content, $key) !== false) {
                        if (in_array($ext, $extensions, true)) {
                            $details['other'][$ext] = ($details['other'][$ext] ?? 0) + 1;
                        } else {
                            $details['other']['otherExtension'] = ($details['other']['otherExtension'] ?? 0) + 1;
                        }
                    }
                }
            }
        }
    }

    private function writeCsv(array $data, array $languages, string $basePath, array $extensions): void
    {
        sort($languages);
        $filename = sprintf('%s/xlf-statistic_%s.csv', $basePath, date('Y-m-d-H-i-s'));
        $f = fopen($filename, 'w');

        $header = array_merge(
            ['path', 'basename'],
            $languages,
            $extensions,
            ['otherExtension', 'countAll', 'unused', 'doubleUse']
        );
        fputcsv($f, $header);

        foreach ($data as $baseName => $keys) {
            foreach ($keys as $key => $info) {
                $row = [];
                $row[] = $info['path'] ?? '';
                $row[] = $baseName . ':' . $key;

                $langCounts = [];
                foreach ($languages as $lang) {
                    $count = $info['xlf'][$lang] ?? 0;
                    $row[] = $count;
                    $langCounts[] = $count;
                }

                $fileCounts = [];
                foreach ($extensions as $ext) {
                    $count = $info['other'][$ext] ?? 0;
                    $row[] = $count;
                    $fileCounts[] = $count;
                }

                $otherExtCount = $info['other']['otherExtension'] ?? 0;
                $row[] = $otherExtCount;

                $countAll = array_sum($fileCounts) + $otherExtCount;
                $row[] = $countAll;

                $row[] = $countAll === 0 ? 'Löschen?' : '';

                $hasDuplicates = false;
                foreach ($langCounts as $langCount) {
                    if ($langCount > 1) {
                        $hasDuplicates = true;
                        break;
                    }
                }
                $row[] = $hasDuplicates ? 'Reduzieren' : '';

                fputcsv($f, $row);
            }
        }

        fclose($f);
    }
}
