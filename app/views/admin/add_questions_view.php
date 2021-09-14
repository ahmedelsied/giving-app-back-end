<?=$this->get_message()?>
<section class="admin-logged admin-dashboard text-center">
    <div class="answer-parent hidden prototype-answer">
        <div class="col-xs-2">
            <input type="radio" title="select-answer" value="" name="right_answer" required="required"/>
        </div>
        <div class="col-xs-8 col-xs-offset-1">
            <input name="" class="form-control answer" type="text" placeholder="اكتب الاختيارات" required="required"/>
        </div>
        <div class="col-xs-1">
            <i class="fa fa-times close remove-answer"></i>
        </div>
        <br>
    </div>
    <div id="edit-question">
        <h3>إضافة السؤال</h3>
        <form id="edit-question-form" action="/admin/questions/create" method="POST">
            <?=$this->_token()?>
            <div class="form-group">
                <div class="col-xs-10  col-xs-offset-2">
                    <textarea class="form-control question"  placeholder="اكتب السؤال" name="question_content" required="required"></textarea>
                </div>
                <div id="all-answers">
                    <div class="answer-parent">
                        <div class="col-xs-2">
                            <input type="radio" title="select-answer" value="1" name="right_answer" required="required"/>
                        </div>
                        <div class="col-xs-8 col-xs-offset-1">
                            <input name="answer_1" class="form-control answer" type="text" placeholder="اكتب الاختيارات" required="required"/>
                        </div>
                        <div class="col-xs-1">
                            <i class="fa fa-times close remove-answer"></i>
                        </div>
                        <br>
                    </div>
                    <div class="answer-parent">
                        <div class="col-xs-2">
                            <input type="radio" title="select-answer" value="2" name="right_answer" required="required"/>
                        </div>
                        <div class="col-xs-8 col-xs-offset-1">
                            <input name="answer_2" class="form-control answer" type="text" placeholder="اكتب الاختيارات" required="required"/>
                        </div>
                        <div class="col-xs-1">
                            <i class="fa fa-times close remove-answer"></i>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <button type="button" class="btn btn-success" id="add-answer">
                    <i class="fa fa-plus fa-mysize"></i>
                </button>
            </div>
            <br>
            <br>
            <br>
            <div class="edit-parent">
                <button class="btn main-btn">إضافة السؤال</button>
            </div>
        </form>
    </div>
</section>