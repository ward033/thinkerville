<?php

    include "DAO/display_questionsDAO.php";

    $item_num = "7";

    $action = new displayQuestionsDAO();
    $action->displayQuestions($item_num);