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
            .mr20{
                margin-right: 20px;
            }
            .ml20{
                margin-left: 20px;
            }
            @page {
                header: page-header;
                footer: page-footer;
            }
            body {
                font-family: DejaVu Sans;
            }
            
            .no-border, .no-border tr, .no-border td {
                border:none !important;
            }
            .page-break {
                page-break-after: always;
            }
        </style>
    </head>
    <body>
        <div class="container is-fullwidth">
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
          
            <table class="ml20 table is-fullwidth no-border">                    
                    <tbody>
                        <tr>                            
                          <td>Naziv elementa/oznaka: <b>{{$review->order->description . " / " . $review->position}}</b></td>                            
                            <td>Datum: <b>{{Carbon\Carbon::parse($review->updated_at)->format('d-m-Y')}}</b></td>
                        </tr>
                        <tr>
                            <td>Za objekat: <b>{{$review->order->project->name}}</b></td>                            
                            <td>Oznaka: <b>{{Carbon\Carbon::parse($review->updated_at)->format('d.m')}}</b></td>
                        </tr>
                    </tbody>
            </table>
<!--          <div class="columns is-mobile">
                <div class="column is-6">
                  <div class="columns is-mobile">
                    <div class="column is-narrow padding-bottom-0"></div>
                    <div class="column border-bottom padding-bottom-0 has-text-centered"></div>
                  </div>
                </div>
                <div class="column is-6">
                  <div class="columns is-mobile">
                    <div class="column is-narrow padding-bottom-0">Datum:</div>
                    <div class="column border-bottom padding-bottom-0 has-text-centered">{{Carbon\Carbon::parse($review->created_at)->format('d-m-Y')}}</div>
                  </div>
                </div>
            </div>
            <div class="columns is-mobile">
                <div class="column is-6">
                  <div class="columns is-mobile">
                    <div class="column is-narrow padding-bottom-0"></div>
                    <div class="column border-bottom padding-bottom-0 has-text-centered"></div>
                  </div>
                </div>
                <div class="column is-6">
                  <div class="columns is-mobile">
                    <div class="column is-narrow padding-bottom-0"></div>
                    <div class="column border-bottom padding-bottom-0 has-text-centered"></div>
                  </div>
                </div>
            </div>-->
          
            <div style="margin: 20px">
                <table class="table is-fullwidth is-bordered">
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

            <div style="margin: 20px">
                <label class="label is-title is-3">Komentar</label>
                <table class="table is-fullwidth is-bordered">                   
                    <tbody>
                        <tr>                                
                            <td class="has-text-justified">{{$review->description}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

          <div class="columns ml20 mr20">
                <div class="column is-12 is-pulled-right">
                  <p class="label is-title is-3">Ček listu popunio</p>                  
                  <p>{{$review->user->profile->name}}</p>
                </div>                
          </div>
        </div>
      
    </body>
</html>




<!--            <htmlpageheader name="page-header">
                <div class="columns">
                    <div class="column has-text-left" style="margin-top: 20px;margin-left: 20px">
                        <figure class="">
                          <img src="http://putinzenjering.com/wp-content/uploads/2017/10/Logo-putinzenjering.jpg">
                        </figure>
                    </div>
                </div>
            </htmlpageheader>
            <div style="text-align: center;">
                <h3>Ček lista ispravnosti bloka</h3>
            </div>
            <div style="margin: 20px; border:1px solid black; width: 45%; height: 20px; float: left;">

            </div>
            <div style="margin: 20px; border:1px solid black; width: 45%; height: 20px; float: left;">

            </div>-->