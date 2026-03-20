<?php    
    class UserController extends AbstractController {
    
        public function __construct(){
            parent::__construct();
        }
    
        public function list() : void
        {
            $um = new UserManager();
            $users = $um->findAll();
        
            $this->render('admin/users/list.html.twig', [
                'users' => $users
            ]);
        }
    
        public function details(int $id) : void
        {
            $um = new UserManager();
            $user = $um->findOne($id);
        
            $this->render('admin/users/details.html.twig', [
                'user' => $user
            ]);
        }
    
        public function update(int $id) : void
        {
            $um = new UserManager();
            $user = $um->findOne($id);
        
            if(!empty($_SESSION["errors"]))
            {
                $errors = $_SESSION["errors"];
                unset($_SESSION["errors"]);
                $this->render('admin/users/update.html.twig', [
                    'user' => $user,
                    "errors" => $errors
                ]);
            }
            else
            {
                $this->render('admin/users/update.html.twig', [
                    'user' => $user
                ]);
            }
        }
    
        public function checkUpdate(int $id) : void
        {
            $_SESSION["errors"] = [];
            $regexEmail = "/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/";
            $email = htmlspecialchars($_POST["email"]);
            $password = htmlspecialchars($_POST["password"]);
            $firstName = htmlspecialchars($_POST["first_name"]);
            $lastName = htmlspecialchars($_POST["last_name"]);

            if(preg_match($regexEmail, $email) && !empty(trim($email)) && !empty(trim($password)) && !empty(trim($firstName)) && !empty(trim($lastName))){
                $um = new UserManager();
                $user = new User($email, $password, $firstName, $lastName);
                $user->setId($id);
                $ret = $um->update($user);
                
                if($ret){
                    unset($_SESSION["errors"]);
                    header("Location: index.php?route=list-users");
                }
                else
                {
                    $_SESSION["errors"][] = "La mise à jour a échoué lors de l'écriture dans la base de données.";
                    header("Location: index.php?route=update-user");
                }
                
            }
            else
            {
                $_SESSION["errors"][] = "Au moins un champ obligatoire est manquant ou invalide.";
                header("Location: index.php?route=update-user");
            }
        }
        
        public function create() : void
        {
            if (!empty($_SESSION["errors"])) {
                $errors = $_SESSION["errors"];
                unset($_SESSION["errors"]);
                $this->render('admin/users/create.html.twig', [
                "errors" => $errors
                ]);
            } 
        else {
            $this->render('admin/users/create.html.twig', [
            ]);
        }
        }
    
        public function checkCreate() : void
        {
            $_SESSION["errors"] = [];
            $regexEmail = "/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/";
            $email = htmlspecialchars($_POST["email"]);
            $password = htmlspecialchars($_POST["password"]);
            $firstName = htmlspecialchars($_POST["first_name"]);
            $lastName = htmlspecialchars($_POST["last_name"]);

            if(preg_match($regexEmail, $email) && !empty(trim($email)) && !empty(trim($password)) && !empty(trim($firstName)) && !empty(trim($lastName)))
            {
                // tous les champs sont remplis
                $um = new UserManager();
                $user = $um->findByEmail($email);
    
                if($user === null)
                {
                    // il n'existe pas, on peut le créer
                    $user = new User($email, $password, $firstName, $lastName);
                    $ret = $um->create($user);
    
                    if($ret)
                    {
                        unset($_SESSION["errors"]);
                        header("Location: index.php?route=list-users");
                    }
                    else
                    {
                        $_SESSION["errors"][] = "La création a échoué lors de l'écriture dans la base de données.";
                        header("Location: index.php?route=create-user");
                    }
                }
                else
                {
                    $_SESSION["errors"][] = "Un utilisateur avec cet email existe déjà.";
                    header("Location: index.php?route=create-user");
                }
            }
            else
            {
                $_SESSION["errors"][] = "Au moins un champ obligatoire est manquant ou invalide.";
                header("Location: index.php?route=create-user");
            }
        }
    
        public function delete(int $id) : void
        {
            $um = new UserManager();
            $um->delete($id);
            header("Location: index.php?route=list-users");
        }
    }
    