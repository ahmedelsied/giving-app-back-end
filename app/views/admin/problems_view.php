<section class="admin-logged admin-dashboard text-center">
    <div id="all-users">
        <div class="container-fluid">
            <h4 class="h3">البلاغات</h4>
            <div class="actions">
                <input class="form-control" placeholder="ابحث عن المستخدمين (يمكنك كتابة قيمة أي عنصر من عناصر الجدول)" type="search" id="search-front">
            </div>
            <?php if(!empty($this->problems)): ?>
            <table id="users-table" class="table table-striped">
                <thead>
                    <tr>
                        <th class="main-color text-center">#id</th>
                        <th class="main-color text-center">كود المحادثه</th>
                        <th class="main-color text-center">مشكله من</th>
                        <th class="main-color text-center">الحاله</th>
                        <th class="main-color text-center">الإجراء</th>
                    </tr>
                </thead>
                <tbody id="myTable">
                <?php foreach($this->problems as $problem): ?>
                    <tr>
                        <td><?=$problem['id']?></td>
                        <td>
                            <a href="/admin/archive/show/<?=$problem['conversation_id']?>"><?=$problem['conversation_id']?></a>
                        </td>
                        <td>
                            <a href="/admin/users/edit/<?=$problem['user_id']?>"><?=$problem['user_id']?></a>
                        </td>
                        <td><?=$this->get_status($problem['status'])?></td>
                        <td>
                            <?php if($problem['status'] == OPEN) : ?>
                            <a href="/admin/problems/show/<?=$problem['id']?>" class="btn ban-btn">مراسله</a>
                            <a href="/admin/problems/close/<?=$problem['id']?>" class="btn btn-danger need_confirm">إقفال المحادثه</a>
                            <?php else: ?>
                            لا يوجد لانها مغلقه
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-center">
                <button id="load_more" class="btn main-btn">تحميل المزيد</button>
            </div>
            <?php else: ?>
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
            ajaxRequest("/admin/problems/load_more","POST",data,"html",success_request,failed_request);
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
                    html += "<td>";
                    html += '<a href="/admin/archive/show/'+e.conversation_id+'">'+e.conversation_id+'</a>';
                    html += "</td>";
                    html += "<td><a href='/admin/users/edit/"+e.user_id+"'>"+e.user_id+"</a></td>";
                    html += "<td>"+get_status(e.status)+"</td>";
                    html += "<td>";
                    if(e.status == <?=OPEN?>){
                        html += '<a href="/admin/problems/show/'+e.id+'" class="btn ban-btn">مراسله</a>';
                        html += '<a href="/admin/problems/close/'+e.id+'" class="btn btn-danger need_confirm">إقفال المحادثه</a>';
                    }else{
                        html += "لا يوجد لانها مغلقه";
                    }
                    html += "</td>";
                    html += "</tr>";
                $("#myTable").append(html);
            });
        }
        function get_status(status){
            return status == <?=OPEN?> ? "مفتوحه" : "مغلقه";
        }
        function failed_request(data){
            console.log(data);
        }
    }
</script>