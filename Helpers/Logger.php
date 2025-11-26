<?php

namespace Helpers;

/**
 * Class that handles reading and writing logs.
 */
readonly class Logger {
	private const string LOG_FILE_FORMAT = 'mihoyo-%04d-%02d.log';

	/**
	 * Creates a new logger instance.
	 *
	 * @param string $logDir Folder where logs are stored.
	 */
	public function __construct(private string $logDir) {
	}

	/**
	 * Writes a new log entry.
	 *
	 * @param bool $success If the action performed was successful or not
	 * @param string $actionType The kind of action that was performed
	 * @param string $entity The entity class name that was affected
	 * @param string $message The message to log
	 */
	public function log(bool $success, string $actionType, string $entity, string $message): void {
		$logFile = sprintf(self::LOG_FILE_FORMAT, date('Y'), date('m'));
		$logPath = $this->logDir . DIRECTORY_SEPARATOR . $logFile;
		$this->ensureLogFileExists($logPath);

		$logMessage = sprintf(
			'[%s] [%s][%s] %s: %s',
			date('Y-m-d H:i:s'),
			$actionType, $entity, $success ? 'SUCCESS' : 'ERROR', $message
		);
		if ($fp = fopen($logPath, 'ab')) {
			fwrite($fp, $logMessage . PHP_EOL);
			fclose($fp);
		}
	}

	/**
	 * Returns a list of the files in the log folder.
	 *
	 * @return string[] List of log files
	 */
	public function getLogFiles(): array {
		if (!file_exists($this->logDir)) {
			return [];
		}

		$files = scandir($this->logDir) ?: [];
		return array_filter($files, static fn($file) => str_ends_with($file, '.log'));
	}

	/**
	 * Returns the content of a log file.
	 *
	 * @param string $logFile Log file name
	 * @return string[] Log file contents, one array item per log file line
	 */
	public function getLogFileContent(string $logFile): array {
		if (!file_exists($this->logDir . DIRECTORY_SEPARATOR . $logFile)) {
			return [];
		}

		return file(
			$this->logDir . DIRECTORY_SEPARATOR . $logFile,
			\FILE_IGNORE_NEW_LINES | \FILE_SKIP_EMPTY_LINES
		) ?: [];
	}

	private function ensureLogFileExists(string $logPath): void {
		if (!file_exists($this->logDir) && !mkdir($this->logDir, 0755, true)) {
			throw new \RuntimeException("Could not create logs directory: $this->logDir");
		}

		if (!file_exists($logPath)) {
			touch($logPath);
			chmod($logPath, 0644);
		}
	}
}
