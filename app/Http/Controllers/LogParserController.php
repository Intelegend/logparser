<?php

namespace App\Http\Controllers;
use Throwable;

class LogParserController extends Controller
{
    public const LOG_DATA_ERROR     = "(\\w+ \\w+ \\d{2} \\d{2}:\\d{2}:\\d{2}.\\d{6} \\d{4}(.*?)Got error 'PHP message: (.*?)hooks)";
    public const APACHE_LOG_DATA   = '(- ((?!200).)*"-")';
    public const SQL_LOG_DATA_WITH_ENTER = "((.*?)(?:male'|female'), (.*?)\s\W+(.*?)(?: )(.*?)(?: )(.*?)(?: )(.*?)(?:,))";

    public function handle()
    {
        $error = [];
        $sql = [];
        $apache = [];

        $filePath = [
            $_SERVER['DOCUMENT_ROOT'].'\logs\sql\U-290723-015_1702332791.sql', 
            $_SERVER['DOCUMENT_ROOT'].'\logs\apache\error2.log',
            $_SERVER['DOCUMENT_ROOT'].'\logs\apache\access.log',
            $_SERVER['DOCUMENT_ROOT'].'\logs\apache\access2.log'
        ];

        foreach ($filePath as $path) {
        
        $file = fopen($path, 'rb');
        $pathInfo = pathinfo($path);
        // Обрабатываем построчно, чтобы не загружать память если логи будут большими.
        while ($row = fgets($file)) {
            try {
                if($pathInfo['basename'] === 'error.log' || $pathInfo['basename'] === 'error2.log') {
                    $error[] = $this->extractErrors(trim($row));
                }
                if($pathInfo['basename'] === 'access.log' || $pathInfo['basename'] === 'access2.log') {
                    $apache[] = $this->extractApatchLogs(trim($row));
                }
                if($pathInfo['basename'] === 'U-290723-015_1702332791.sql') {
                    $sql[] = $this->extractSql(trim($row));
                }
            } catch (Throwable $t) {
                continue;
            }
        }
    }
        fclose($file);
        return view('logsviews', ['sql' => $sql, 'apaches' => $apache, 'errors' => $error]);
    }

    protected function extractErrors(string $row): array
    {
        $replacedText = preg_replace('/proxy_fcgi:(.*?)\\d{5}:/ui','', $row);
        $replacedText = preg_replace('/Please see(.*?);/ui','', $replacedText);
        preg_match(self::LOG_DATA_ERROR, $replacedText, $matches);
        return $matches;
    }

    protected function extractApatchLogs(string $row): array
    {
        preg_match(self::APACHE_LOG_DATA, $row, $matches);
        return $matches;
    }

    protected function extractSql(string $row): array
    {
        preg_match(self::SQL_LOG_DATA_WITH_ENTER, $row, $matches);
        return $matches;
    }
}
