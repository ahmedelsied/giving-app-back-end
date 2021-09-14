<?=$this->get_message()?>
<section class="admin-logged admin-dashboard text-center">
    <div id="all-users">
        <div class="container-fluid">
            <h4 class="h3">أسئلة المستمع</h4>
            <div class="actions">
                <input class="form-control" placeholder="ابحث عن المستخدمين (يمكنك كتابة قيمة أي عنصر من عناصر الجدول)" type="search" id="search-front">
            </div>
            <div class="add-question text-left">
                <a href="/admin/questions/add" class="btn btn-success">
                    <i class="fa fa-plus fa-mysize"></i>
                </a>
            </div>
            <?php if(!empty($this->all_questions)): ?>
            <table id="users-table" class="table table-striped">
                <thead>
                    <tr>
                        <th class="main-color text-center">#id</th>
                        <th class="main-color text-center">السؤال</th>
                        <th class="main-color text-center">الإجراء</th>
                    </tr>
                </thead>
                <tbody id="myTable">
                <?php foreach($this->all_questions as $question): ?>
                    <tr>
                        <td><?=$question['id']?></td>
                        <td><?=$question['question_content']?></td>
                        <td>
                            <a name="delete question" href="/admin/questions/delete/<?=$question['id']?>" class="btn btn-danger need_confirm">مسح</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else:?>
            <div class="margin:10px">
                <p class="lead">لا يوجد أسئله للمستمع بعد</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>