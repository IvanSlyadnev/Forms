<?php

namespace App\Tables;

use App\Models\Question;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;
use Illuminate\Database\Eloquent\Builder;
//use PhpParser\Builder;
class QuestionTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */

    protected $form;
    public function __construct($form) {
        $this->form = $form;
    }


    protected function table(): Table
    {
        return (new Table())->model(Question::class)
            ->routes([
                'index'   => ['name' => 'forms.questions.index', 'params' => ['form' =>$this->form->id]],
                'create'  => ['name' => 'forms.questions.create', 'params' => ['form' =>$this->form->id]],
                'edit'    => ['name' => 'questions.edit'],
                'destroy' => ['name' => 'questions.destroy'],
            ])
            ->activateRowsNumberDefinition(false)
            ->query(function (Builder $query) {
                $query->where('form_id', $this->form->id);
            })
            ->destroyConfirmationHtmlAttributes(fn(Question $question) => [
                'data-confirm' => __('Are you sure you want to delete the entry :entry?', [
                    'entry' => $question->database_attribute,
                ]),
            ]);
    }

    /**
     * Configure the table columns.
     *
     * @param \Okipa\LaravelTable\Table $table
     *
     * @throws \ErrorException
     */
    protected function columns(Table $table): void
    {
        $table->column('question')->title('Вопросы');
    }

    /**
     * Configure the table result lines.
     *
     * @param \Okipa\LaravelTable\Table $table
     */
    protected function resultLines(Table $table): void
    {
        //
    }
}
