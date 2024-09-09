<?php

namespace Tests\Feature\User;

use App\Domain\User\Models\User;

class ExportUsersCsvTest extends UsersTestCase
{
    /**
     * Valida a exportação de usuários
     */
    public function test_export_users_to_csv_file(): void
    {
        User::factory()->create();

        $response = $this->get(
            route('users.export.csv')
        );

        $fileName = 'users_export_' . date('Y-m-d') . '.csv';

        $response->assertOk()->assertDownload($fileName);

        $this->assertFileExists(sys_get_temp_dir() . DIRECTORY_SEPARATOR . $fileName);
    }
}
