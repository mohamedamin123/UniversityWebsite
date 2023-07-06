<?php
    require_once("MySql.php");

    class MatiereDB extends MySql {

        // METHODS
        public function insert($nom, $coeff, $credit,  $heursCours, $heursTP, $uniteID) {
            $query = "INSERT INTO matiere(nom, coefficient_mat, credit_mat, heursCours, heursTP, uniteID) VALUES (:nom, :coeff, :credit, :heursCours, :heursTP, :uniteID)"; 
            $secureArray = array( 
                ":nom" => $nom,
                ":coeff" => $coeff,
                ":credit" => $credit,
                ":heursCours" => $heursCours,
                ":heursTP" => $heursTP,
                ":uniteID" => $uniteID,
            );

            $this->request($query, $secureArray);
        }

        public function delete($id) {
            $query = "DELETE FROM matiere WHERE id = :id"; 
            $secureArray = array( 
                ":id" => $id,
            );

            $this->request($query, $secureArray);
        }

        /* QUERY METHODS */

        public function get($matiereId) {
            return $this->request(
                "SELECT * FROM matiere WHERE id = :matiereId",
                array(":matiereId" => $matiereId),
                1
            );
        }

        public function getAll($uniteID) {
            return $this->request(
                "SELECT * FROM matiere WHERE uniteID = :uniteID",
                array(
                    ":uniteID" => $uniteID
                ),
                2
            );
        }

        /* Emploi */

        public function getByPlanEtd($planId) {
            return $this->request(
                "SELECT m.id as id, m.nom as nom, u.planEtudeId as plan 
                FROM matiere as m
                JOIN unite u ON (m.uniteID = u.id)
                JOIN planetude pe ON (u.planEtudeID = pe.id and pe.id = :planId)
                WHERE pe.id = :planId",

                array(
                    ":planId" => $planId
                ),
                2
            );
        }
    }