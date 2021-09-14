<?=$this->get_message()?>
<section class="admin-logged admin-dashboard text-center">
    <div id="all-users">
        <div class="container-fluid">
            <h4 class="h3">أرشيف المحادثات</h4>
            <div class="actions">
                <input class="form-control" placeholder="ابحث عن المستخدمين (يمكنك كتابة قيمة أي عنصر من عناصر الجدول)" type="search" id="search-front">
            </div>
            <?php if(!empty($this->archived_chat)): ?>
            <table id="users-table" class="table table-striped">
                <thead>
                    <tr>
                        <th class="main-color text-center">#id</th>
                        <th class="main-color text-center">كود المستمع</th>
                        <th class="main-color text-center">كود المستخدم</th>
                        <th class="main-color text-center">تقييم المستمع</th>
                        <th class="main-color text-center">تاريخ الانشاء</th>
                        <th class="main-color text-center">تاريخ الانتهاء</th>
                        <th class="main-color text-center">الإجراء</th>
                    </tr>
                </thead>
                <tbody id="myTable">
                <?php foreach($this->archived_chat as $chat): ?>
                    <tr>
                        <td><?=$chat['id']?></td>
                        <td>
                            <a href="/admin/users/edit/<?=$chat['listener_id']?>"><?=$chat['listener_id']?></a>
                        </td>
                        <td>
                            <a href="/admin/users/edit/<?=$chat['user_id']?>"><?=$chat['user_id']?></a>
                        </td>
                        <td><?=$chat['listener_rate']?></td>
                        <td><?=$chat['created_at']?></td>
                        <td><?=$chat['deleted_at']?></td>
                        <td>
                            <a title="show chat" href="/admin/archive/show/<?=$chat['id']?>" class="btn ban-btn">أظهر المحادثه</a>
                            <a title="delete chat" href="/admin/archive/delete/<?=$chat['id']?>" class="btn btn-danger">مسح</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-center">
                <button id="load_more" class="btn main-btn">تحميل المزيد</button>
            </div>
            <?php else:?>
            <div class="margin:10px">
                <p class="lead">لا يوجد محادثات مؤرشفه بعد</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<script>
    window.onload = function(){
        $("#load_more").on("click",function(){
            var data = {
                
            };
            ajaxRequest("/admin/archive/load_more","POST",data,"html",success_request,failed_request);
        });

        function success_request(data){
            data = JSON.parse(data)['data'];
            if(data.length <= 0){
                $("#load_more").parent().remove();
                return;
            };
            data.forEach(function(e){
                var html = "<tr>";
                    html += "<td>"+e.id+"</td>";
                    html += "<td><a href='/admin/users/edit/"+e.listener_id+"'>"+e.listener_id+"</a></td>";
                    html += "<td><a href='/admin/users/edit/"+e.user_id+"'>"+e.user_id+"</a></td>";
                    html += "<td>"+e.listener_rate+"</td>";
                    html += "<td>"+e.created_at+"</td>";
                    html += "<td>"+e.deleted_at+"</td>";
                    html += "<td>";
                    html += '<a title="show chat" href="/admin/archive/show/'+e.id+'" class="btn ban-btn">أظهر المحادثه</a>';
                    html += '<a title="delete chat" href="/admin/archive/delete/'+e.id+'" class="btn btn-danger">مسح</a>';
                    html += "</tr>";
                $("#myTable").append(html);
            });
        }
        function failed_request(data){
            console.log(data);
        }
    }
</script>