<?php

namespace App\Integrations;

class APIusersintegration extends JSONIntegration
{
    public $toInsert;
    public $toUpdate;
    public $users;


    public function whatToUpdateAndInsert(array $users)
    {
        $idsArray = array_column($users, 'id');
        $existingUsers = \DB::table('users_basic_info')->select('id')->whereIn('id', array_column($users, 'id'))->get();
        $existingUsers = $existingUsers->pluck('id')->toArray();
        $this->toInsert = array_diff($idsArray, $existingUsers);
        $this->toUpdate = array_diff($idsArray, $this->toInsert);
    }


    public function insertOrUpdateUsers(array $users)
    {
        $this->insertUsers($users);
        $this->updateUsers($users);

    }

    public function insertUsers($users)
    {
        if (!empty($this->toInsert)) {
            foreach ($users as $key => $user) {
                if (in_array($user['id'], $this->toInsert)) {
                    $address = $user['address'];
                    $address['latitude'] = $address['geo']['lat'];
                    $address['longtitude'] = $address['geo']['lng'];
                    $address['website'] = $user['website'];
                    $address['userId'] = $user['id'];
                    unset($address['geo']);
                    try {
                        \DB::table('users_basic_info')->insert(['id' => $user['id'], 'name' => $user['name'], 'username' => $user['username'], 'phone_number' => $user['phone'], 'email' => $user['email']]);
                        \DB::table('users_additional_info')->insert($address);
                        \DB::table('users_companies')->insert(['companyName' => $user['company']['name'], 'catchPhrase' => $user['company']['catchPhrase'], 'short' => $user['company']['bs'], 'userId' => $user['id']]);
                    } catch (\Exception $e) {
                        $this->exceptions[] = [$e->getMessage, 'Błąd w dodawaniu użytkowników', $user];
                    }
                }
            }
        }

    }

    public function updateUsers($users)
    {
        if (!empty($this->toUpdate)) {
            foreach ($users as $key => $user) {
                if (in_array($user['id'], $this->toUpdate)) {
                    $address = $user['address'];
                    $address['latitude'] = $address['geo']['lat'];
                    $address['longtitude'] = $address['geo']['lng'];
                    $address['website'] = $user['website'];
                    $address['userId'] = $user['id'];
                    unset($address['geo']);
                    try {
                        \DB::table('users_basic_info')->where('id', $user['id'])->update(['id' => $user['id'], 'name' => $user['name'], 'username' => $user['username'], 'phone_number' => $user['phone'], 'email' => $user['email']]);
                        \DB::table('users_additional_info')->where('userId', $user['id'])->update($address);
                        \DB::table('users_companies')->where('userId', $user['id'])->update(['companyName' => $user['company']['name'], 'catchPhrase' => $user['company']['catchPhrase'], 'short' => $user['company']['bs'], 'userId' => $user['id']]);
                    } catch (\Exception $e) {
                        $this->exceptions[] = [$e->getMessage, 'Błąd w updatowaniu użytkowników', $user];
                    }
                }
            }
        }
    }

}
