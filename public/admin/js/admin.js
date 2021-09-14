$(function(){
    var ans_count = $(".answer").last().attr("name");
    ans_count = typeof(ans_count) != 'undefined' ? parseInt(ans_count[ans_count.length-1])+1 : null;

    search('#search-front','#users-table #myTable tr');
    // Start Edit Questions Page

    // Handle Remvoe Answer
    $("body").on("click",".remove-answer",function(){
        if($(this).parents(".answer-parent").siblings().length < 2){
            alert("أقل عدد اجابات ممكن هو 2");
            return;
        }
        $(this).parents(".answer-parent").remove();
        ans_count--;
    });

    // Handle Add Answer
    $("#add-answer").on('click',function(){
        var new_ans = $(".prototype-answer").eq(0).clone();
        new_ans.find("input[name='right_answer']").val(ans_count);
        new_ans.find(".answer").attr("name","answer_"+ans_count);
        new_ans.appendTo("#all-answers");
        $("#edit-question .prototype-answer").removeClass("hidden");
        ans_count++;
    });

    // End Edit Questions Page
});