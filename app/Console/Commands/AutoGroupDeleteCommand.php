<?php

namespace App\Console\Commands;

use App\Models\JoinGroup;
use App\Models\User;
use App\Models\Vertical;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoGroupDeleteCommand extends Command
{
    protected $signature = 'auto-delete-groups:cron';

    protected $description = 'auto deleting groups after 30 days from their creation date';

    public function handle()
    {
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        // $groupsToDelete = JoinGroup::where('created_at', '<', $thirtyDaysAgo)->get();
        $groupsToDelete = DB::table('join_groups')->where('created_at', '<', $thirtyDaysAgo)->get();
        Log::info('Groups to be deleted: ', ['group_ids' => $groupsToDelete->pluck('id')->toArray()]);
        foreach ($groupsToDelete as $group) {
            if ($group->full == 0) {
                JoinGroup::create([
                    'plan_id' => $group->plan_id,
                    'tier' => $group->tier,
                    'name' => $group->name,
                    'image' => $group->getOriginal('image'),
                    'total_members' => 0,
                    'total_brands' => 0,
                    'full' => '0',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $group->delete();
        }

        $deletedUsers = User::onlyTrashed()->where('deleted_at', '<', $thirtyDaysAgo)->forceDelete();

        Log::info('Users permanently deleted: ', ['user_ids' => $deletedUsers]);
    }
}
