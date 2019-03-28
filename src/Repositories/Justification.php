<?php

namespace App\Repositories;

use App\Entities;
use App\Exceptions\NotFoundException;
use App\Models;
use Exception;

/**
 * Repository de Justificativas
 *
 * Class Justification
 * @package App\Repositories
 */
class Justification
{
    /**
     * @var Models\Justification $model
     */
    protected $model;

    /**
     * User constructor.
     * @param Models\Justification $model
     */
    public function __construct(Models\Justification $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $parameters
     */
    public function createJustification(array $parameters)
    {

        $justificationEntity = (new Entities\Justification())
                ->setTitle($parameters['title']);

        try {

            $fetchedJustification = $this->model->findByTitle($justificationEntity->getTitle());

            if (!empty($fetchedJustification)) {
                throw new Exception('Já existe uma justificativa com o mesmo titulo.');
            }

        } catch (NotFoundException $exception) {

            $this->model->save($justificationEntity);
        }
    }

    /**
     * Método para adicionar "_tests" na tabela de model da repository
     * para que a model interfira nos dados de um tabela de testes
     */
    public function setTestsEnvironment()
    {
        $this->model->setTableName(
          $this->model->getTableName() . "_tests"
        );

        return $this;
    }
}