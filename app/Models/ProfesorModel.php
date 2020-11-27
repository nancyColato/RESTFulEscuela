<?php namespace App\Models;

use CodeIgniter\Model;

class ProfesorModel extends Model{

    protected $table            = 'profesor';//nombre de la tabla
    protected $primaryKey       = 'id'; //identificador de la tabla PK
    
    protected $returnType       = 'array';//tratarse como array
    protected $allowedFields    = ['nombre', 'apellido', 'profesion','telefono', 'dui'];//campos de las tablas

    //fechas de cambios
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    //reglas
    protected $validationRules  = [
        'nombre'        => 'required|regex_match[/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+\D\s*$/]|min_length[3]|max_length[75]',
        'apellido'      => 'required|regex_match[/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+\D\s*$/]|min_length[3]|max_length[75]',
        'dui'           => 'permit_empty|regex_match[/^\d{8}-\d{1}$/]|min_length[10]|max_length[10]',
        'profesion'        => 'required|alpha|min_length[3]max_length[3]',
        'telefono'        => 'required|regex_match[/^[267]{1}\d{3}-\d{4}$/]|min_length[9]|max_length[9]',
    ];

    protected $validationMessages = [
        'dui'           =>[
            'regex_match'=>'El formato debe coincidir con 00000000-0'
        ],

        'genero'           =>[
            'regex_match'=>'Solo puede elegir F o M como genero'
        ],
        'nombre'           =>[
            'regex_match'=>'El formato de nombre no es aceptado'
        ],
        'apellido'           =>[
            'regex_match'=>'El formato de apellido no es aceptado'
        ]

    ];

    protected $skipValidation = false;

      //funcion para endpoint
      function consulta_profesor($id) 
      { 
        return $this->asArray()
        -> select('concat(p.nombre," ", p.apellido)  as nombre, p.profesion, p.telefono ')
        ->from('profesor p')
        ->where(['p.id'=>$id])
        ->first();
      }
}
