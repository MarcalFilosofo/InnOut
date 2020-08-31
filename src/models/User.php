<?php
   // require_once(realpath(MODEL_PATH . '/Model.php'));
    class User extends Model{
        protected static $tableName = 'users';
        protected static $columns = [
            'id',
            'name',
            'password',
            'email',
            'start_date',
            'end_date',
            'is_admin',
        ];

        public static function getActiveUserCount(){
            return static::getCount(['raw' => 'end_date IS NULL']);
        }

        public function insert(){
            $this->validate();
            $this->is_admin = $this->is->admin ? 1 : 0;
            if(!$this->end_date) $this->end_date = null;
            return parent::insert();
        }

        public function update(){
            $this->validate();
            $this->is_admin = $this->is->admin ? 1 : 0;
            if(!$this->end_date) $this->end_date = null;
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            return parent::update();
        }

        private function validate (){
            $erros = [];

            if(!$this->name){
                $erros['name'] = 'Nome é um campo obrigatório.';
            }
            if(!$this->email){
                $erros['email'] = 'Email é um campo obrigatório.';
            } elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
                $erros['email'] = 'Email invalido';
            }
            if(!$this->start_date){
                $erros['start_date'] = 'Data de admissão é um campo obrigatorio';
            }elseif(DateTime::createFromFormat('d-m-Y', $this->start_date)){
                $erros['start_date'] = 'Data de admissão deve seguir o padrão dd/mm/yyyy';
            }
            if(!$this->end_date && DateTime::createFromFormat('Y-m-d', $this->end_date)){
                $erros['end_date'] = 'Data de desligamento deve seguir o padrão dd/mm/yyyy';
            }
            if(!$this->password){
                $erros['password'] = 'Senha é um campo obrigatório.';
            }
            if(!$this->confirm_password){
                $erros['confirm_password'] = 'Confirmar a senha é um campo obrigatório.';
            }elseif($this->confirm_password && $this->password
                && $this->confirm_password !== $this->password){
                    $erros['password'] = 'As senhas não são iguais.';
                    $erros['confirm_password'] = 'As senhas não são iguais';

            }


            if(count($erros) > 0){
                throw new ValidationException($erros);
            }
        }


    }