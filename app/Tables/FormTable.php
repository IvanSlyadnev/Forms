<?php

namespace App\Tables;

use App\Models\Form;
use App\Models\User;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;
use Illuminate\Database\Eloquent\Builder;
//use PhpParser\Builder;

class FormTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    protected function table(): Table
    {
        return (new Table())->model(Form::class)
            ->routes([
                'index'   => ['name' => 'forms.index'],
                'create'  => ['name' => 'forms.create'],
                'edit'    => ['name' => 'forms.edit'],
                'destroy' => ['name' => 'forms.destroy'],
                'show'    => ['name'=> 'forms.show']
            ])->query(function (Builder $query) {
                $query->where('user_id', $this->user->id);
            })->destroyConfirmationHtmlAttributes(fn(Form $form) => [
                'data-confirm' => __('Вы уверены что хотите удалить форму :form?  ', [
                    'form' => $form->name,
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
        $table->column()->html(function (Form $form) {
            $url = route('forms.questions.index', $form->id);
            return "<a href='{$url}'>{$form->name}</a>";
        })->title('Форма');
        $table->column()->value(function (Form $form) {
            return $form->questions()->count();
        })->title('кол-во вопросов');
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
