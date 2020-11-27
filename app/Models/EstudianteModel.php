<?php namespace App\Models;

use CodeIgniter\Model;

class EstudianteModel extends Model{

    protected $table            = 'estudiante';//nombre de la tabla
    protected $primaryKey       = 'id'; //identificador de la tabla PK
    
    protected $returnType       = 'array';//tratarse como array
    protected $allowedFields    = ['nombre', 'apellido', 'dui', 'genero', 'carnet', 'grado_id' ];//campos de las tablas

    //fechas de cambios
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    //reglas
    protected $validationRules  = [
        'nombre'        => 'required|regex_match[/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+\D\s*$/]|min_length[3]|max_length[75]',
        'apellido'      => 'required|regex_match[/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+\D\s*$/]|min_length[3]|max_length[75]',
        'dui'           => 'permit_empty|regex_match[/^\d{8}-\d{1}$/]',
        'genero'        => 'required|regex_match[/^[FfMm]$/]|max_length[1]',
        'grado_id'      => 'required|integer|is_valid_grado',
        'carnet'        => 'required|regex_match[/^[Uu]20[0-2]{1}[\d{1}]\d{4}$/]',
    ];

    protected $validationMessages = [
        'carnet'        =>[
            'regex_match'=>'El carnet debe coincidir con el formato U20150000'
        ],

        'grado_id'       =>[
            'is_valid_grado'=>'El Id del grado no es invalido!'
        ],

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
    function consulta_estudiante($id) 
    { 
            return $this->asArray()
            -> select('DISTINCTROW concat(e.nombre," ", e.apellido)  as nombre, e.genero,  e.carnet')
            ->from('estudiante e')
            ->where(['e.grado_id'=>$id])
            ->findAll();
    }
}

?>