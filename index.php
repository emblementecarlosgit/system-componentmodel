<?php
require_once __DIR__ . '/vendor/autoload.php';

use Attributes\Attribute\{
    Range,
    Required,
    MaxStringLength,
    MinStringLength,
    RegularExpression
};

class Index {
    #[Required(ErrorMessage: 'O Campo idade é obrigatório.'), Range(18, 25, ErrorMessage: 'Você precisa ter entre 18 e 25 anos.')]
    public ?int $idade;

    #[MaxStringLength(8)]
    public ?int $dodo;

    #[MinStringLength(5)]
    public ?int $pais;

    #[RegularExpression('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', ErrorMessage: 'O E-mail informado é inválido.')]
    public string $colaboradores;
}

class EntityFactory {
    public static function create (object $class_name, object $data_transfer_objects): void
    {
        $reflection_entity = new \ReflectionClass($class_name);
        $reflection_dto = new \ReflectionClass($data_transfer_objects);
        $reflection_dto_properties = $reflection_dto->getProperties();

        for ($i=0; $i < count($reflection_dto->getProperties()); $i++) { 
            $dto_property_name = $reflection_dto->getProperties()[$i]->name;
            $dto_property_value = $reflection_dto->getProperty($dto_property_name)->getValue($data_transfer_objects);

            $entity_property_attributes = $reflection_entity->getProperty($dto_property_name)->getAttributes();

            $reflection_entity->getProperty($dto_property_name)->setValue($class_name, $dto_property_value);

            /**
             * Neste laço a factory por meio de reflection, acessa o método validate e faz a validação
             */
            foreach ($entity_property_attributes as $entity_property) {
                $entity_property->newInstance()->validate($dto_property_value);
            }
            /**
             * Neste laço a Factory irá popular a entidade
             */
            foreach ($reflection_dto_properties as $dto_property) {
                $dto_property_value = $reflection_dto->getProperty($dto_property->name)->getValue($data_transfer_objects);
                $reflection_entity->getProperty($dto_property->name)->setValue($class_name, $dto_property_value);
            }
        }
    }
}

class Tete {
    public ?int $dodo = 8;
    public ?int $pais = 5;
    public ?int $idade = 26;
    public string $colaboradores = 'carlos@mail.com';
}

$tete = new Tete; 
$index = new Index;

EntityFactory::create(class_name: $index, data_transfer_objects: $tete);