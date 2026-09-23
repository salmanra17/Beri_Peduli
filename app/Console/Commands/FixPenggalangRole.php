<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class FixPenggalangRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-penggalang-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update role donatur yang punya kampanye menjadi penggalang';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $users = User::where('role', 'donatur')
            ->whereHas('kampanyes')
            ->get();

        if ($users->isEmpty()) {
            $this->info('Tidak ada user yang perlu diupdate.');

            return self::SUCCESS;
        }

        foreach ($users as $user) {
            $user->update(['role' => 'penggalang']);
            $this->line("{$user->name} <{$user->email}>");
        }

        $this->info("{$users->count()} user berhasil diupdate ke penggalang.");

        return self::SUCCESS;
    }
}
