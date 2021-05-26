<?php

namespace App\Tables;

use App\Models\User;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;
use Illuminate\Database\Eloquent\Builder;

class UserTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */

    protected $chat;

    public function __construct($chat) {
        $this->chat = $chat;
    }

    protected function table(): Table
    {
        return (new Table())->model(User::class)
            ->routes([
                'index'   => ['name' => 'chats.show', 'params' => ['chat' => $this->chat->id]],
                'destroy' => ['name' => 'chats.users.destroy', 'params' => ['chat' => $this->chat->id]]
            ])
            ->query(function (Builder $query) {
                $query->whereHas('chats', function (Builder $query) {
                   $query->where('chats.id', $this->chat->id);
                });
            })
            ->destroyConfirmationHtmlAttributes(fn(User $user) => [
                'data-confirm' => __('Are you sure you want to delete the entry :entry?', [
                    'entry' => $user->database_attribute,
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
        $table->column('name');
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
