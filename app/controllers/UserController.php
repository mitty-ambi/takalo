<?php
    namespace app\controllers;
    use app\models\Users;
    
    class UserController {
        /**
         * Traiter la connexion
         * @return bool true si la connexion réussit, false sinon
         */
        public function login($username = null, $email = null, $mot_de_passe = null) {
            // Si les paramètres ne sont pas fournis, récupérer depuis $_POST
            $username = $username ?? $_POST['username'] ?? '';
            $email = $email ?? $_POST['email'] ?? '';
            $mot_de_passe = $mot_de_passe ?? $_POST['mdp'] ?? '';
            
            // Vérifier que les champs ne sont pas vides
            if(empty($username) || empty($email) || empty($mot_de_passe)) {
                return false;
            }
            
            // Créer une instance de Users et valider
            $user = new Users($username, $email, $mot_de_passe);
            return $user->valider_login($username, $email, $mot_de_passe);
        }

        /**
         * Traiter l'enregistrement
         * @return bool true si l'enregistrement réussit, false sinon
         */
        public function register($username = null, $email = null, $mot_de_passe = null) {
            // Si les paramètres ne sont pas fournis, récupérer depuis $_POST
            $username = $username ?? $_POST['username'] ?? '';
            $email = $email ?? $_POST['email'] ?? '';
            $mot_de_passe = $mot_de_passe ?? $_POST['mdp'] ?? '';
            
            // Vérifier que les champs ne sont pas vides
            if(empty($username) || empty($email) || empty($mot_de_passe)) {
                return false;
            }
            
            // Créer une instance de Users et enregistrer
            $user = new Users($username, $email, $mot_de_passe);
            return $user->enregistrer();
        }

        /**
         * Obtenir tous les utilisateurs
         * @return array
         */
        public function obtenir_tous_utilisateurs() {
            $user = new Users();
            return $user->obtenir_tous();
        }

        /**
         * Obtenir un utilisateur par username
         * @param string $username
         * @return array|false
         */
        public function obtenir_utilisateur($username) {
            $user = new Users();
            return $user->obtenir_par_username($username);
        }

        /**
         * Mettre à jour un utilisateur
         * @param string $username
         * @param string $email
         * @param string $mot_de_passe
         * @return bool
         */
        public function mettre_a_jour_utilisateur($username, $email, $mot_de_passe) {
            $user = new Users($username, $email, $mot_de_passe);
            return $user->mettre_a_jour();
        }

        /**
         * Supprimer un utilisateur
         * @param string $username
         * @return bool
         */
        public function supprimer_utilisateur($username) {
            $user = new Users();
            return $user->supprimer($username);
        }
    }
?>