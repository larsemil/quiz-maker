<div class="facit">
    <h2>Rätta svar</h2>
    @foreach($questions as $id=>$question)
        <div class="question">
            <p><strong>{{$id +1}}. {{$question[0]}}</strong></p>
            <p>
                @php($charTransform = ['1','X','2'])
                @for($i = 1; $i<=3; $i++)
                    @if($i == $question[4])
                        <strong>
                            @endif

                            {{$charTransform[$i -1]}}. {{$question[$i]}},
                            @if($i == $question[4])
                        </strong>
                    @endif
                @endfor
            </p>
        </div>

    @endforeach
    <h3>Rätt tipsrad:</h3>
    @foreach($questions as $key => $question)
        {{$charTransform[$question[4] -1 ]}}
        @if($key % 3 === 2)
            &nbsp;
        @endif
    @endforeach
</div>