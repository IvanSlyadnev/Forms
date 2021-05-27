<?php

namespace App\Tables;

use App\Models\Chat;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;
use Illuminate\Database\Eloquent\Builder;
class ChatGroupTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */

    private $group;

    public function __construct($group) {
        $this->group = $group;
    }

    protected function table(): Table
    {
        return (new Table())->model(Chat::class)
            ->routes([
                'index'   => ['name' => 'chats.index'],
                'show'    => ['name' => 'chats.show'],
                'destroy' => ['name' => 'groups.chats.destroy', 'params' => ['group' => $this->group->id]]
            ])
            ->query(function (Builder $query) {
                $query->whereHas('groups', function (Builder $query) {
                    $query->where('groups.id', $this->group->id);
                });
            })
            ->destroyConfirmationHtmlAttributes(fn(Chat $chat) => [
                'data-confirm' => __('Are you sure you want to delete the entry :entry?', [
                    'entry' => $chat->database_attribute,
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
        $table->column()->html(function (Chat $chat) {
            $url = route('chats.show', $chat->id);
            return "<a href='{$url}'>{$chat->id}</a>";
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
