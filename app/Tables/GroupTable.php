<?php

namespace App\Tables;

use App\Models\Group;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class GroupTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected function table(): Table
    {
        return (new Table())->model(Group::class)
            ->routes([
                'index'   => ['name' => 'groups.index'],
                'create'  => ['name' => 'groups.create'],
                'edit'    => ['name' => 'groups.edit'],
                'destroy' => ['name' => 'groups.destroy'],
            ])
            ->destroyConfirmationHtmlAttributes(fn(Group $group) => [
                'data-confirm' => __('Are you sure you want to delete the entry :entry?', [
                    'entry' => $group->database_attribute,
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
        $table->column()->html(function (Group $group) {
            $url = route('groups.show', $group);
            return "<a href = '{$url}'>{$group->name}</a>";
        });

        $table->column()->html(function (Group $group) {
           $url = route('chats.groups.show', $group->id);
           return "<a href='{$url}'><button class='btn btn-group'>Посмотреть чаты</button><a>";
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
