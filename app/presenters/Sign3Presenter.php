<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Forms\SignFormFactory;
use App\Forms\TemplateControl;


/**
 * Sign in/out presenters.
 */
class Sign3Presenter extends BasePresenter
{
	/** @var SignFormFactory @inject */
	public $factory;


	/**
	 * Sign-in form factory.
	 * @return TemplateControl
	 */
	protected function createComponentSignInForm()
	{
		$form = $this->factory->create(function () {
			$this->redirect('Homepage:');
		});
		return new TemplateControl($form, __DIR__ . '/templates/components/form.latte');
	}
}
