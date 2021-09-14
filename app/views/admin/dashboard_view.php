<section class="admin-logged admin-dashboard text-center">
    <div id="statistics">
        <div class="col-md-3">
            <div class="statistics-box total-users">
                <p>اجمالي المستخدمين</p>
                <div class="statistics-items">
                    <i class="fa fa-users fa-2x"></i>
                    <div class="pull-left">
                        <b class="value"><?=$this->pad($this->total_users);?></b>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="statistics-box opened-chats">
                <p>المحادثات المفتوحه</p>
                <div class="statistics-items">
                    <i class="fas fa-comment-alt fa-2x"></i>
                    <div class="pull-left">
                        <b class="value"><?=$this->pad($this->opened_chat);?></b>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="statistics-box total-problems">
                <p>اجمالي الابلاغات</p>
                <div class="statistics-items">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                    <div class="pull-left">
                        <b class="value"><?=$this->pad($this->total_problems);?></b>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="statistics-box total-banned-users">
                <p>المستخدمين المحظورين</p>
                <div class="statistics-items">
                    <i class="fas fa-ban fa-2x"></i>
                    <div class="pull-left">
                        <b class="value"><?=$this->pad($this->banned_users);?></b>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="user-curve"></div>
    <div id="latest-users">
        <div class="container-fluid">
            <h4>آخر المستخدمين المسجلين</h4>
            <table id="users-table" class="table table-striped">
                <thead>
                    <tr>
                        <th class="main-color text-center">#id</th>
                        <th class="main-color text-center">الاسم</th>
                        <th class="main-color text-center">البريد الالكتروني</th>
                        <th class="main-color text-center">تاريخ الميلاد</th>
                        <th class="main-color text-center">المدينة</th>
                        <th class="main-color text-center">النوع</th>
                        <th class="main-color text-center">الصلاحيات</th>
                        <th class="main-color text-center">الإجراء</th>
                        <th class="main-color text-center">تاريخ الانضمام</th>
                    </tr>
                </thead>
                <tbody id="myTable">
                <?php if(!empty($this->latest_users)): ?>
                <?php foreach($this->latest_users as $user): ?>
                    <tr>
                        <td><?=$user['id']?></td>
                        <td><?=$user['full_name']?></td>
                        <td><?=$user['email']?></td>
                        <td><?=$user['birthdate']?></td>
                        <td><?=$user['city']?></td>
                        <td><?=$this->gender($user['gender'])?></td>
                        <td><?=$this->type($user['type']);?></td>
                        <td>
                            <a href="/admin/users/edit/<?=$user['id']?>" class="btn btn-success">تعديل</a>
                            <a href="/admin/users/<?=$user['banned'] ? "unban" : "ban"?>/<?=$user['id']?>" class="btn ban-btn"><?=$user['banned'] ? "إلغاء الحظر" : "حظر"?> </a>
                            <a href="/admin/users/remove/<?=$user['id']?>" class="btn btn-danger need_confirm">مسح</a>
                        </td>
                        <td><?=$user['joined_at']?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="text-center">
                <p class="lead">لا يوجد مستخدمين بعد</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Year', 'Users'],
            <?php foreach($this->users_curve as $count):?>
            <?="[\"".$count["joined_at"]."\",".$count["count"]."],";?>
            <?php endforeach; ?>
        ]);

        
        var options = {
            title: 'نمو عدد المستخدمين',
            titleTextStyle: {
                color: '#4C61D5'
            },
            curveType: 'function',
            legend: {position : 'right'},
            series: {
                0: { color: '#4C61D5' },
            },
            hAxis: { minValue: 0, maxValue: 20 },
            pointSize: 10,
            backgroundColor:'#0000',
            vAxis : {
                gridlines : {
                    color : '#dcdcdc'
                }
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('user-curve'));

        chart.draw(data, options);

    }
</script>