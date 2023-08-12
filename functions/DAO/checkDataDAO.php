<?php
    include "BaseDAO.php";
    class checkDataDAO extends BaseDAO {
        function checkDataFunctions($data, $totalNum){
            $user_answer = $data;
            $correct="0";
            $wrong="0";
            $iteration=1;
            $score=0;
            foreach($data as $key => $value){
                $i=$iteration++;
                foreach($value as $item){
                    $this->openConn();
                    $stmt = $this->dbh->prepare("SELECT * FROM tbl_answer WHERE answer_id = ?");
                    $stmt->bindParam(1, $item);
                    $stmt->execute();
                    $this->closeConn();

                    while($row_answer_list = $stmt->fetch()){
                        $this->openConn();
                        $stmt_question = $this->dbh->prepare("SELECT * FROM tbl_questions WHERE question_id = ?");
                        $stmt_question->bindParam(1, $row_answer_list[2]);
                        $stmt_question->execute();
                        $this->closeConn();
                        while($row_question_list = $stmt_question->fetch()){
                            $answer_string = $row_question_list[3];
                            
                            if ($answer_string === $row_answer_list[1]){
                                $correct++;
                            }else{
                                $wrong++;
                            }
                        }
                    }
                }
            }
            $ave = floatval($correct/$i*100);
            $message = "";
            if($ave <= 75){
                $message = "<div class='col-md-8 mr-auto'>
                                <div id='pass'>
                                    <h1 class='text-center fw-bold text-danger'>UNFORTUNATELY</h1>
                                    <p class='text-center'>You've <strong class='text-danger'>FAILED</strong> the Quiz with an average score of</p>
                                    <h1 class='text-center my-4 fw-bolder text-danger' style='font-size: 70px'>".$ave."%</h1>
                                    <p class='text-center'>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo officia facere dolorum? Illo rerum quibusdam
                                        natus dicta eius, sequi eum ipsa iusto officia vero molestias error cum, saepe dolore delectus.</p>
                                    </div>
                                <center>
                                    <buttan class='btn btn-warning btn-lg rounded-5 text-white px-5' type='button'><i class='fa-regular fa-circle-play'></i> Retake Quiz</button>
                                </center>
                            </div>";
            }else{
                $message = "<div id='pass'>
                                <h1 class='text-center fw-bold text-success'>CONGRATULATIONS!</h1>
                                <p class='text-center'>You've <strong class='text-success'>PASSED</strong> the Quiz with an average score of</p>
                                <h1 class='text-center my-4 fw-bolder text-success' style='font-size: 70px'>".$ave."%</h1>
                                <p class='text-center'>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo officia facere dolorum? Illo rerum quibusdam
                                    natus dicta eius, sequi eum ipsa iusto officia vero molestias error cum, saepe dolore delectus.
                                </p>
                            </div>";
            }
            echo $message;
        }
    }