<?php

/**
 * This file is part of the ApiGen (http://apigen.org)
 *
 * For the full copyright and license information, please view
 * the file license.md that was distributed with this source code.
 */

namespace ApiGen\Console;

use ApiGen\Configuration\ConfigurationOptions as CO;
use ApiGen\Console;
use Symfony\Component\Console\Helper\ProgressBar as ProgressBarHelper;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;


class ProgressBar
{

	/**
	 * @var Console\IO
	 */
	private $consoleIO;

	/**
	 * @var ProgressBarHelper
	 */
	private $bar;


	public function __construct(Console\IO $consoleIO)
	{
		$this->consoleIO = $consoleIO;
	}


	/**
	 * @param int $maximum
	 */
	public function init($maximum = 1)
	{
		$this->bar = new ProgressBarHelper($this->getOutput(), $maximum);
		$this->bar->setFormat($this->getBarFormat());
		$this->bar->start();
	}


	/**
	 * @param int $increment
	 */
	public function increment($increment = 1)
	{
		$this->bar->advance($increment);
		if ($this->bar->getProgress() === $this->bar->getMaxSteps()) {
			$this->consoleIO->getOutput()->writeln(' - Finished!');
		}
	}


	/**
	 * @return OutputInterface
	 */
	private function getOutput()
	{
		if ($this->consoleIO->getOutput()) {
			return $this->consoleIO->getOutput();
		}
		return new NullOutput;
	}


	/**
	 * @return string
	 */
	private function getBarFormat()
	{
		if ($this->consoleIO->getInput()->getOption(CO::DEBUG)) {
			return 'debug';

		} else {
			return '<comment>%percent:3s% %</comment>';
		}
	}

}
