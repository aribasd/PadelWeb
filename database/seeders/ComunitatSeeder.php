<?php

namespace Database\Seeders;

use App\Models\Comunitat;
use App\Models\User;
use Illuminate\Database\Seeder;

class ComunitatSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->where('role', 'admin')->first();
        $users = User::query()->where('role', '!=', 'admin')->inRandomOrder()->take(12)->get();

        $comunitats = collect([
            [
                'nom' => 'SocialPadel Barcelona',
                'descripcio' => 'Quedades setmanals i partits nivell mitjà/alt.',
                'direccio' => 'Barcelona',
                'lat' => 41.3850639,
                'lng' => 2.1734035,
                'imatge' => 'https://images.unsplash.com/photo-1646649853703-7645147474ba?auto=format&fit=crop&w=1600&q=60',
            ],
            [
                'nom' => 'Padel Girona',
                'descripcio' => 'Comunitat per organitzar reserves i fer amistats.',
                'direccio' => 'Girona',
                'lat' => 41.9794,
                'lng' => 2.8214,
                'imatge' => 'https://images.unsplash.com/photo-1620741211724-0a8a3266d4d0?auto=format&fit=crop&w=1600&q=60',
            ],
            [
                'nom' => 'Padel Tarragona',
                'descripcio' => 'Partits relaxats, nivell iniciació i mitjà.',
                'direccio' => 'Tarragona',
                'lat' => 41.1189,
                'lng' => 1.2445,
                'imatge' => 'https://www.google.com/imgres?q=padel&imgurl=https%3A%2F%2Fstatic.apidae-tourisme.com%2Ffilestore%2Fobjets-touristiques%2Fimages%2F21%2F52%2F31732757.jpg&imgrefurl=https%3A%2F%2Fwww.valdisere.com%2Fen%2Foffres%2Fpadel-court-val-disere-en-4201091%2F&docid=rqWIcrAssfgmAM&tbnid=SAH9YlM-7KoL9M&vet=12ahUKEwjv7JvW5qSUAxUphv0HHRlbBeoQnPAOegQIKBAB..i&w=5464&h=3640&hcb=2&ved=2ahUKEwjv7JvW5qSUAxUphv0HHRlbBeoQnPAOegQIKBAB',
            ],
            [
                'nom' => 'Lleida Padel Club',
                'descripcio' => 'Organització de lliguetes i quedades.',
                'direccio' => 'Lleida',
                'lat' => 41.6176,
                'lng' => 0.6200,
                'imatge' => 'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?auto=format&fit=crop&w=1600&q=60',
            ],
            [
                'nom' => 'Comunitat Costa Brava',
                'descripcio' => 'Partits a l’aire lliure i bon ambient.',
                'direccio' => 'Costa Brava',
                'lat' => null,
                'lng' => null,
                'imatge' => 'https://www.google.com/imgres?q=padel&imgurl=https%3A%2F%2Fallforpadel.com%2Fmodules%2Fprestablog%2Fviews%2Fimg%2Fgrid-for-1-7%2Fup-img%2Fthumb_443.jpg%3F04dc47d33a552e84c38093f4ca91c608&imgrefurl=https%3A%2F%2Fallforpadel.com%2Fes%2Fblog%2Fpuede-el-padel-ser-deporte-olimpico-n443%3Fsrsltid%3DAfmBOorvlE69JtqxQs1EPGsCRa4vCF885mq-gR7wnt43IHX1jH9-rFuO&docid=WqH0oYzF86HQZM&tbnid=oS6OKwvEtjWT9M&vet=12ahUKEwjv7JvW5qSUAxUphv0HHRlbBeoQnPAOegQIahAB..i&w=900&h=516&hcb=2&ved=2ahUKEwjv7JvW5qSUAxUphv0HHRlbBeoQnPAOegQIahAB',
            ],  
        ])->map(function (array $c) {
            return array_merge($c, [
                // Camps obligatoris a la migració original
                'membres' => '0',
                'rol' => 'usuari',
            ]);
        });

        $created = collect();

        foreach ($comunitats as $data) {
            $created->push(Comunitat::query()->create($data));
        }

        // Assignacions a la pivot comunitat_user (rol del membre dins la comunitat)
        foreach ($created as $i => $comunitat) {
            if ($admin && $i === 0) {
                $comunitat->users()->syncWithoutDetaching([$admin->id => ['rol' => 'admin']]);
            }

            $take = $users->random(min($users->count(), 6));
            foreach ($take as $u) {
                $comunitat->users()->syncWithoutDetaching([$u->id => ['rol' => 'usuari']]);
            }

            // Actualitza el camp "membres" (string) amb el total actual
            $comunitat->membres = (string) $comunitat->users()->count();
            $comunitat->save();
        }
    }
}

