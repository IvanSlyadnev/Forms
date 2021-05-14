<?php

namespace App\Tables;

use App\Models\Form;
use App\Models\Lead;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class LeadTable extends AbstractTable
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
        return (new Table())->model(Lead::class)
            ->routes([
                'index' => ['name' => 'forms.show', 'params' => ['form' => $this->form->id]],
                'show'  => ['name' => 'leads.show']
            ])
            ->destroyConfirmationHtmlAttributes(fn(Lead $lead) => [
                'data-confirm' => __('Are you sure you want to delete the entry :entry?', [
                    'entry' => $lead->database_attribute,
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
        $table->column()->html(function (Lead $lead) {
            $url = route('leads.show', $lead->id);
            return "<a href='{$url}'>{$lead->id}</a>";
        });
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
