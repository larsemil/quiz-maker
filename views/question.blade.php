<div class="page">
    @if(isset($question[5]) && $question[5] != "")
        <img src="{{$question[5]}}">
    @endif
    <h1>{{$question_no}}. {{$question[0]}}</h1>
    <div class="answers">
        <p>1. {{$question[1]}}</p>
        <p>X. {{$question[2]}}</p>
        <p>2. {{$question[3]}}</p>
    </div>
</div>