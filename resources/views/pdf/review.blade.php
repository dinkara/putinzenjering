<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">
        <style>
            .padding-bottom-0{
                padding-bottom:0px;
            }
            .border-bottom{
                border-bottom:2px solid black;
            }
            @page {
                header: page-header;
                footer: page-footer;
            }
            body {
                font-family: DejaVu Sans;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <htmlpageheader name="page-header">
                <div class="columns">
                    <div class="column has-text-left" style="margin-top: 20px;margin-left: 20px">
                        <figure class="">
                          <img src="http://putinzenjering.com/wp-content/uploads/2017/10/Logo-putinzenjering.jpg">
                        </figure>
                    </div>
                </div>
            </htmlpageheader>
            <div class="has-text-centered">
                <p class="title is-3" style="margin-bottom: 10px">Ček lista ispravnosti bloka</p>
            </div>
          <div class="columns">
                <div class="column is-6">
                  <div class="columns">
                    <div class="column is-narrow padding-bottom-0">Naziv elementa/oznaka:</div>
                    <div class="column border-bottom padding-bottom-0 has-text-centered">{{$review->order->description}}</div>
                  </div>
                </div>
                <div class="column is-6">
                  <div class="columns">
                    <div class="column is-narrow padding-bottom-0">Datum:</div>
                    <div class="column border-bottom padding-bottom-0 has-text-centered">{{Carbon\Carbon::parse($review->created_at)->format('d-m-Y')}}</div>
                  </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-6">
                  <div class="columns">
                    <div class="column is-narrow padding-bottom-0">Za objekat:</div>
                    <div class="column border-bottom padding-bottom-0 has-text-centered">{{$review->order->project->name}}</div>
                  </div>
                </div>
                <div class="column is-6">
                  <div class="columns">
                    <div class="column is-narrow padding-bottom-0">Oznaka:</div>
                    <div class="column border-bottom padding-bottom-0 has-text-centered"></div>
                  </div>
                </div>
            </div>
          
            <div style="margin: 20px">
                <table class="table is-fullwidth">
                    <thead>
                        <tr>
                            <th>Pitanje</th>
                            <th>Ispravnost</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($review->questions as $question)
                            <tr>
                                <th>{{$question->text}}</th>
                                <td>{{$question->pivot->status ? 'Ispravno' : 'Neispravno'}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
