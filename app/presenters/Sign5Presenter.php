<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Forms\FormFactory;
use Nette;


/**
 * Sign in/out presenters.
 */
class Sign5Presenter extends BasePresenter
{
	/** @var FormFactory @inject */
	public $factory;


	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
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

		$form->setRenderer(new \App\Forms\Renderer(__DIR__ . '/templates/components/form.latte'));

		return $form;
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
