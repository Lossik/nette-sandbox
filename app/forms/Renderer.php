<?php

declare(strict_types=1);

namespace App\Forms;

use Nette;


class Renderer extends Nette\Object implements Nette\Forms\IFormRenderer
{
	/** @var string */
	private $file;


	public function __construct($file)
	{
		$this->file = $file;
	}


	public function render(Nette\Forms\Form $form, $template = null)
	{
		$template->getEngine()->render($this->file, ['form' => $form]);
	}
}
