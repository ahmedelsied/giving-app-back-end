<?=$this->get_message();?>
<section class="admin-logged admin-dashboard text-center">
    <div id="all-users">
        <div class="container-fluid">
            <h4 class="h3">جميع المستخدمين</h4>
            <div class="actions row">
                <button class="btn btn-primary col-xs-2 col-md-1 col-md-offset-1" id="search_in_back">بحث</button>
                <input id="search-front" class="search-inpt col-xs-9" placeholder="ابحث عن المستخدمين (في حالة البحث في الخلفيه يرجى كتابة id المستخدم)" type="search">
            </div>
            <div class="filter text-right">
                <input name="user-type" value="banned" type="radio" id="banned"/>
                <label for="banned">المحظورون</label>
                <input name="user-type" value="<?=LISTENER?>" type="radio" id="listener"/>
                <label for="listener">مستمع</label>
                <input name="user-type" value="<?=USER?>" type="radio" id="user"/>
                <label for="user">مستخدم عادي</label>
                <input name="user-type" value="<?=BOTH?>" type="radio" id="both"/>
                <label for="both">الصلاحيتين</label>
                <input name="user-type" value="" type="radio" id="all"/>
                <label for="all">الجميع</label>
            </div>
            <div class="add-question text-left">
                <a href="/admin/users/add" class="btn btn-success">
                    <i class="fa fa-plus fa-mysize"></i>
                </a>
            </div>
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
                <?php if(!empty($this->users)): ?>
                <?php foreach($this->users as $user): ?>
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
            <div class="text-center">
                    <button class="btn main-btn" id="load_more">تحميل المزيد</button>
                </div>
            <?php else: ?>
            <div class="text-center">
                <p class="lead">لا يوجد مستخدمين بعد</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<script>
    window.onload = function(){
        $("#load_more").on("click",function(){
            var checked_val = $("input[name='user-type']:checked").val(),
                type = typeof checked_val != "undefined" ? checked_val : "",
                data = {
                    type : type,
                    hash_token : "<?=$this->get_token()?>"
                };
            ajaxRequest("/admin/users/load_more","POST",data,"html",success_request,failed_request);
        });
        $("input[name='user-type']").on("change",function(){
            var checked_val = $(this).val(),
                type = typeof checked_val != "undefined" ? checked_val : "",
                data = {
                    first_time : true,
                    type : type,
                    hash_token : "<?=$this->get_token()?>"
                };
            ajaxRequest("/admin/users/load_more","POST",data,"html",type_change_success,failed_request);
        });
        function type_change_success(data){
            data = JSON.parse(data);
            if(data.length <= 0){
                alert("لا يوجد المزيد");
                return;
            };
            $("#myTable").html("");
            data.forEach(function(e){
                $("#myTable").append(prepare_html(e));
            });
        }
        $("#search_in_back").on("click",function(){
            let inpt_search_val = $(".search-inpt").val();
            if(inpt_search_val == ""){
                alert("من فضلك قم بكتابة id المستخدم");
                return;
            }
            var data = {
                id : parseInt($(".search-inpt").val()),
                hash_token : "<?=$this->get_token()?>"
            }
            ajaxRequest("/admin/users/find_user","POST",data,"html",search_success,failed_request);
        });
        function success_request(data){
            data = JSON.parse(data);
            if(data.length <= 0){
                alert("لا يوجد المزيد");
                return;
            };
            data.forEach(function(e){
                $("#myTable").append(prepare_html(e));
            });
        }
        function search_success(data){
            // console.log(data);
            // return;
            data = JSON.parse(data);
            if(data.length <= 0){
                alert("لا يوجد نتيجه");
                return;
            };
            $("#myTable").html(prepare_html(data[0]));
        }
        function prepare_html(e){
                var banned = parseInt(e.banned) == 1 ? "unban" : "ban";
                var ban_text = parseInt(e.banned) == 1 ? "إلغاء الحظر" : "حظر";
                var html = "<tr>";
                    html += "<td>"+e.id+"</td>";
                    html += "<td>"+e.full_name+"</td>";
                    html += "<td>"+e.email+"</td>";
                    html += "<td>"+e.birthdate+"</td>";
                    html += "<td>"+e.city+"</td>";
                    html += "<td>"+e.gender+"</td>";
                    html += "<td>"+e.type+"</td>";
                    html += "<td>";
                    html += '<a href="/admin/users/edit/'+e.id+'" class="btn btn-success">تعديل</a>';
                    html += '<a href="/admin/users/'+ banned + "/" +e.id+'"/ class="btn ban-btn">'+ban_text+'</a>';
                    html += '<a href="/admin/users/remove/'+e.id+'" class="btn btn-danger need_confirm">مسح</a>';
                    html += "</td>";
                    html += "<td>"+e.joined_at+"</td>";
                    html += "</tr>";
                    return html;
        }
        function failed_request(data){
            console.log(data);
        }
    }
</script>