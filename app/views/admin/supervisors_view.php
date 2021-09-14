<?=$this->get_message();?>
<section class="admin-logged admin-dashboard text-center">
    <div id="all-users">
        <div class="container-fluid">
            <h4 class="h3">جميع المشرفون</h4>
            <div class="actions">
                <input class="form-control" placeholder="ابحث عن المستخدمين (يمكنك كتابة قيمة أي عنصر من عناصر الجدول)" type="search" id="search-front">
            </div>
            <div class="add-question text-left">
                <a href="/admin/supervisors/add" class="btn btn-success">
                    <i class="fa fa-plus fa-mysize"></i>
                </a>
            </div>
            <?php if(!empty($this->supervisors)): ?>
            <table id="users-table" class="table table-striped">
                <thead>
                    <tr>
                        <th class="main-color text-center">#id</th>
                        <th class="main-color text-center">الاسم</th>
                        <th class="main-color text-center">اسم المستخدم</th>
                        <th class="main-color text-center">الإجراء</th>
                        <th class="main-color text-center">تاريخ الاضافه</th>
                    </tr>
                </thead>
                <tbody id="myTable">
                <?php foreach($this->supervisors as $supervisor): ?>
                    <tr>
                        <td><?=$supervisor['id']?></td>
                        <td><?=$supervisor['full_name']?></td>
                        <td><?=$supervisor['user_name']?></td>
                        <td>
                            <a title="edit supervisor" href="/admin/supervisors/edit/<?=$supervisor['id']?>" class="btn btn-success">Edit</a>
                            <a title="remove supervisor" href="/admin/supervisors/remove/<?=$supervisor['id']?>" class="btn btn-danger need_confirm">Remove</a>
                        </td>
                        <td><?=$supervisor['created_at']?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="text-center">
                <p class="lead">لم تتم إضافة مشرفين بعد</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>