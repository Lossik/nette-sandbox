<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Forms\FormFactory;
use App\Forms\TemplateControl;
use Nette;


/**
 * Sign in/out presenters.
 */
class Sign4Presenter extends BasePresenter
{
	/** @var FormFactory @inject */
	public $factory;


	/**
	 * Sign-in form factory.
	 * @return TemplateControl
	 */
	protected function createComponentSignInForm()
	{
		$form = $this->factory->create();
		$form->addText('username', 'Username:')
			->setRequired('Please enter your username.');

		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.');

		$form->addCheckbox('remember', 'Keep me signed in');

		$form->addSubmit('send', 'Sign in');
		$form->onSuccess[] = [$this, 'signInFormSucceeded'];

		return new TemplateControl($form, __DIR__ . '/templates/components/form.latte');
	}


	public function signInFormSucceeded($form, $values)
	{
		try {
			$this->getUser()->setExpiration($values->remember ? '14 days' : '20 minutes');
			$this->getUser()->login($values->username, $values->password);
			$this->redirect('Homepage:');

		} catch (Nette\Security\AuthenticationException $e) {
			$form->addError($e->getMessage());
		}
	}
}
