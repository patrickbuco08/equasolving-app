@extends('layouts.app', ['title' => 'Match History'])


@section('content')
{{-- css style here --}}

{{-- HTML here --}}
<h3>Match History</h3>
<table id="match-history" style="background-color: white">
    <thead>
        <tr>
            <th>Match ID</th>
            <th>Oponent</th>
            <th>Oponent Score</th>
            <th>My Score</th>
            <th>Status</th>
            <th>Match Date</th>
        </tr>
    </thead>
</table>
<script>
    $(document).ready(function () {
        var matchHistoryTable = $('#match-history').DataTable({
            "searching": false,
            "searchable": false,
            paging: false,
            ordering: false,
            info: false,
        });
        $.ajax({
            url: "http://127.0.0.1:8000/user/2",
            type: "GET",
            dataType: "json",
            success: function (response) {
                for(var i = 0; i< response.matches.length;i++){
                    var datamatch = response.matches[i];
                    var datadetails = datamatch.details;
                    var rowadded =  matchHistoryTable.row.add([datadetails.id, 
                                                datadetails.enemy.user.name, 
                                                datadetails.enemy.score, 
                                                datamatch.score, 
                                                Status(datamatch.status,datadetails.enemy.status),
                                                dateformat(datamatch.details.created_at)
                                            ]).draw(false);
                    $('#match-history tbody tr').each(function() {
                        var test = $(this).find("td").eq(4);  
                        var testval = test.html();  
                        test.addClass(ColorStatus(testval));
                    });
                    
                } 
                
            }
        });
        function Status(status1, status2){
            if(status1 == status2)
                return "Draw";
            else if(status1 < status2)
                return "Lose"
            else
                return "Win"
        }
        function ColorStatus(status){
            if(status == "Win")
                return "win-status"
            else if(status == "Lose")
                return "lose-status"
            else(status == "Draw")
                return "draw-status"
        }
        function dateformat(date){
            date = new Date(date);
            year = date.getFullYear();
            month = date.getMonth()+1;
            dt = date.getDate();
            time = new Date(date).toLocaleTimeString('en',
                { timeStyle: 'short', 
                    hour12: true, 
                    timeZone: 'UTC' 
                });
            
            if (dt < 10) {
                dt = '0' + dt;
            }
            if (month < 10) {
            month = '0' + month;
            }
            return dt+'-'+month+'-'+year + ' ' + time
        }
    });

</script>
@endsection