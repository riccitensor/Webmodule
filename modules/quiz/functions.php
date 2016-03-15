<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';  
   require_once 'core/sql.php';

class modQuiz extends constructClass{    
    var $odp = '';    
    var $pyt = '';
    var $id = 0;

    public function getQuiz($id){
        $data = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_quiz} WHERE id=$id");                
        $this->id = $data['id'];
        $this->a = $data['answer_a'];
        $this->b = $data['answer_b'];
        $this->c = $data['answer_c'];
        $this->d = $data['answer_d'];
        $this->pyt = $data['title'];
        if ($data['correct_a']){$this->odp = 'a'; }
        if ($data['correct_b']){$this->odp = 'b'; }
        if ($data['correct_c']){$this->odp = 'c'; }
        if ($data['correct_d']){$this->odp = 'd'; }        
    }
    
    public function getRandomQuestion($courses){
        if ($courses>0){
            $data = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_quiz} WHERE courses_id = '$courses' ORDER BY RAND()");
        } else {
            $data = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_quiz} ORDER BY RAND()");
        }        
        $this->id = $data['id'];
        $this->a = $data['answer_a'];
        $this->b = $data['answer_b'];
        $this->c = $data['answer_c'];
        $this->d = $data['answer_d'];
        $this->pyt = $data['title'];        
        if ($data['correct_a']){$this->odp = 'a'; }
        if ($data['correct_b']){$this->odp = 'b'; }
        if ($data['correct_c']){$this->odp = 'c'; }
        if ($data['correct_d']){$this->odp = 'd'; }
    }
    
    public function getRandomId($courses){
        if ($courses>0){
            $data = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_quiz} WHERE courses_id = '$courses' ORDER BY RAND()");
        } else {
            $data = $this->sqlconnector->rlo("SELECT * FROM {$this->pageController->variables->base_quiz} ORDER BY RAND()");
        }
        return $data['id'];
    }    
}

global $modQuiz; $modQuiz = new modQuiz();

?>