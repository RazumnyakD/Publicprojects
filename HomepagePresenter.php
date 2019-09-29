<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    private $database;

    public function __construct(Nette\Database\Context $database)
{
    $this->database = $database;
}

        protected function createComponentProjectForm(): UI\Form
    {
        $form = new UI\Form; // means Nette\Application\UI\Form

        $form->addText('name', 'Název Projektu:')
            ->setRequired();


        $form->addText('date', 'Datum odevzdání:')
            ->setType('date')
            ->setRequired();


        $form->addSelect('limit', 'Časové omezení', [
            'True' => 'Časově omezený projekt',
            'False' => 'Časově omezený projekt'
        ])
        ->setRequired();

        $form->addCheckbox('web', 'Webový projekt')
            ->setDefaultValue(true)
        ->setRequired();

        $form->addSubmit('send', 'Vložit nový projekt');
        $form->onSuccess[] = [$this, 'projectFormSucceeded'];
        return $form;
    }
        public function projectFormSucceeded(UI\Form $form, \stdClass $values): void
    {
        $postId = $this->getParameter('postId');

        $this->database->table('prehled_projektu')->insert([
            'nazev_projektu' => $values->name,
            'datum_odevzdani' => $values->date,
            'typ_projektu' => $values->limit,
            'web_projekt' => $values->web,
        ]);

        $this->flashMessage('Děkuji za nově vložený projekt :) ', 'success');
        $this->redirect('this');


    }


    }
