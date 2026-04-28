<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;




class Pista extends Model
{

 protected $table = 'pistes';

   use HasFactory;

        protected $fillable = [
        'nom',
        'activa',
        'doble_vidre',
        'imatge',
        'comunitat_id',
    ];

    protected $casts = [
        'activa' => 'boolean',
        'doble_vidre' => 'boolean',
    ];

    /**
     * Format per al component React ProjectShowcase (title, description, year, link, image).
     */
    public function toProjectShowcaseItem(): array
    {
        return [
            'id' => $this->getKey(),
            'title' => $this->nom,
            'description' => $this->doble_vidre
                ? 'Pista coberta amb doble vidre.'
                : 'Pista sense doble vidre.',
            'year' => $this->created_at?->format('Y') ?? '',
            'link' => route('pistes.show', $this),
            'editLink' => route('pistes.edit', $this),
            'editor' => 'Editar',
            'image' => $this->imatge ? asset('storage/'.$this->imatge) : '',
        ];
    }

    public function comunitat()
    {
        return $this->belongsTo(Comunitat::class, 'comunitat_id');
    }

}


