<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Evenemnt /</span> Modifier un evenement
</h4>
<div class="row">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <div class="card-body"><div>
                    <form action="{{ route('events.update',$event->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <label for="defaultFormControlInput" class="form-label">Evenement</label>
                        <input type="text" class="form-control" id="defaultFormControlInput" value="{{$event->nom}}"  name="nameEvent" aria-describedby="defaultFormControlHelp" />
                        @if ($errors->has('nameEvent'))
                            <div class="error">
                                {{ $errors->first('nameEvent') }}
                            </div>
                        @endif
                        <br/>
                        <label for="defaultFormControlInput" class="form-label">Lieu</label>
                        <input type="text" class="form-control" id="defaultFormControlInput" value="{{$event->Lieu}}"  name="lieuEvent" aria-describedby="defaultFormControlHelp" />
                        @if ($errors->has('lieuEvent'))
                            <div class="error">
                                {{ $errors->first('lieuEvent') }}
                            </div>
                        @endif
                        <br/>
                        <label for="defaultFormControlInput" class="form-label">Description</label>
                        <input type="text" class="form-control" id="defaultFormControlInput" value="{{$event->description}}"  name="descEvent" aria-describedby="defaultFormControlHelp" />
                        @if ($errors->has('descEvent'))
                            <div class="error">
                                {{ $errors->first('descEvent') }}
                            </div>
                        @endif
                        <br/>
                        <label for="defaultFormControlInput" class="form-label">Date</label>
                        <input type="date" class="form-control" id="defaultFormControlInput" value="{{$event->date}}"   name="dateEvent" aria-describedby="defaultFormControlHelp" />
                        @if ($errors->has('dateEvent'))
                            <div class="error">
                                {{ $errors->first('dateEvent') }}
                            </div>
                        @endif
                        <br/>
                        <label for="defaultFormControlInput" class="form-label">Heure Debut</label>
                        <input type="datetime-local" class="form-control" id="defaultFormControlInput" value="{{$event->start}}"  name="start" aria-describedby="defaultFormControlHelp" />
                        @if ($errors->has('start'))
                            <div class="error">
                                {{ $errors->first('start') }}
                            </div>
                        @endif
                        <br/>
                        <label for="defaultFormControlInput" class="form-label">Heure fin</label>
                        <input type="datetime-local" class="form-control" id="defaultFormControlInput" value="{{$event->end}}"  name="end" aria-describedby="defaultFormControlHelp" />
                        @if ($errors->has('end'))
                            <div class="error">
                                {{ $errors->first('end') }}
                            </div>
                        @endif
                        <br/>
                        <label for="defaultFormControlInput" class="form-label">Couleur</label>
                        <input type="color" class="form-control" id="defaultFormControlInput" value="{{$event->color}}" name="color" />
                        <br/>
                        <button type="submit" class="btn btn-primary">Modifier</button>








                    </form>
                </div>
            </div>
        </div>


    </div>
</div>
