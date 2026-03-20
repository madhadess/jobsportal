<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Find the Bitlis job post
$post = \App\JobPost::where('title', '11111')->first();
if ($post) {
    echo "=== JOB POST ===\n";
    echo "Title: {$post->title}\n";
    echo "state_id: {$post->state_id}\n";
    echo "city_id: {$post->city_id}\n";
    echo "category_id: {$post->category_id}\n";

    // Get the state name from DB
    $state = \App\State::find($post->state_id);
    echo "State name: " . ($state ? $state->state . " (country_id: {$state->country_id}, lang: {$state->lang})" : 'NOT FOUND') . "\n";
}

// Check all Bitlis entries in states table
echo "\n=== ALL BITLIS STATES ===\n";
$allBitlis = \App\State::where('state', 'LIKE', '%Bitlis%')->get();
foreach ($allBitlis as $s) {
    echo "ID: {$s->id} | state: {$s->state} | country_id: {$s->country_id} | lang: {$s->lang}\n";
}

// Check logged-in user or last user with work_locations
echo "\n=== USERS WITH WORK_LOCATIONS ===\n";
$users = \App\User::whereNotNull('work_locations')->take(5)->get();
foreach ($users as $u) {
    echo "User: {$u->id} ({$u->getName()}) | work_locations: " . json_encode($u->work_locations) . " | state_id: {$u->state_id}\n";

    // Check if their work_locations contain any Bitlis ID
    $locs = is_array($u->work_locations) ? $u->work_locations : [];
    foreach ($locs as $locId) {
        $locState = \App\State::find($locId);
        if ($locState) {
            echo "  -> Loc ID {$locId}: {$locState->state} (country_id: {$locState->country_id})\n";
        }
    }
}
