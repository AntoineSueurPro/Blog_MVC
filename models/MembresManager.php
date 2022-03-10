<?php

namespace models;

use PDO;

class MembresManager extends Model
{

    public function insert($membre)
    {
        $query = Model::getBdd()->prepare('INSERT INTO membres (pseudo, email, password, created_at) VALUES (:pseudo, :email, :password, NOW())');
        $query->execute(array(
            'pseudo' => $membre['pseudo'],
            'email' => $membre['email'],
            'password' => $membre['password']
        ));
    }

    public function checkPseudoAndMail($membre)
    {
        $email = $membre['email'];
        $pseudo = $membre['pseudo'];
        $query = Model::getBdd()->query("SELECT (pseudo) FROM membres WHERE pseudo =  '{$pseudo}'  OR email =  '{$email}'  ");
        $result = $query->fetchAll();
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function login($credientials)
    {
        $pseudo = $credientials['pseudo'];
        $query = Model::getBdd()->prepare("SELECT * FROM membres WHERE pseudo = :pseudo");
        $query->execute(array(
            ':pseudo' => $pseudo
        ));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            if (password_verify($credientials['password'], $result['password'])) {
                return $result;
            } else {
                return false;
            }
        }
    }

    public function selectAll()
    {
        $query = Model::getBdd()->query('SELECT * FROM membres');
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function selectOne($id) {
        $query = Model::getBdd()->prepare('SELECT * FROM membres where id_membre = :id');
        $query->execute(array(
            'id' => $id
        ));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updatePassword($old_password, $id, $new_password) {
        $query = Model::getBdd()->prepare("SELECT password FROM membres WHERE id_membre = :id");
        $query->execute(array(
            ':id'=> $id
        ));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if(password_verify($old_password, $result['password'])) {
            $password =  password_hash($new_password, PASSWORD_BCRYPT);
            $query = Model::getbdd()->prepare("UPDATE membres SET password = :password WHERE id_membre = :id");
            $query->execute(array(
                'password' => $password,
                'id' => $id
            ));
            return true;
        } else {
            return false;
        }
    }

    public function updateAvatar($avatar, $id) {
        $query = Model::getBdd()->prepare("UPDATE membres SET avatar = :avatar WHERE id_membre = :id");
        $query->execute(array(
            'avatar' => $avatar,
            'id' => $id
        ));
    }

    public function deleteAccount($id) {
        $query = Model::getBdd()->prepare('DELETE FROM membres WHERE id_membre = :id');
        $query->execute(array(
            'id' => $id
        ));
    }

    public function getId($pseudo) {
        $query = Model::getBdd()->prepare('SELECT id_membre FROM membres WHERE pseudo = :pseudo');
        $query->execute(array(
            'pseudo' => $pseudo
        ));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['id_membre'];
    }

    public function getNbMembrebyDate() {
        $query = Model::getBdd()->query('SELECT COUNT(*) as nb, membres.created_at FROM membres GROUP BY created_at ORDER BY created_at');
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        $res = json_encode($res, true);
        echo $res;
    }
}