<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectLink;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = base_path('projects.json');

        if (! file_exists($jsonPath)) {
            $this->command->error('projects.json not found.');

            return;
        }

        $projects = json_decode(file_get_contents($jsonPath), true);

        if (! is_array($projects)) {
            $this->command->error('Invalid projects.json format.');

            return;
        }

        foreach ($projects as $projectData) {
            $slug = Str::slug($projectData['name']);

            $project = Project::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $projectData['name'],
                    'env' => $projectData['env'] ?? null,
                    'image' => $projectData['image'] ?? null,
                    'status' => $projectData['status'] ?? 'actualizado',
                    'prod_url' => $projectData['prod'] ?? null,
                    'local_url' => $projectData['local'] ?? null,
                    'hidden_from_boss' => false,
                ]
            );

            if (isset($projectData['links']) && is_array($projectData['links'])) {
                foreach ($projectData['links'] as $linkData) {
                    if (empty($linkData['label'])) {
                        continue;
                    }

                    ProjectLink::firstOrCreate(
                        ['project_id' => $project->id, 'label' => $linkData['label']],
                        [
                            'prod_url' => $linkData['prod'] ?? null,
                            'local_url' => $linkData['local'] ?? null,
                        ]
                    );
                }
            }
        }

        $this->command->info('Projects migrated successfully.');
    }
}
