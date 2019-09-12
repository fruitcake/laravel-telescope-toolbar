<?php
/** @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries */
$data = $entries->first()->content;

$dumper = new \Symfony\Component\VarDumper\Dumper\HtmlDumper();
$varCloner = new \Symfony\Component\VarDumper\Cloner\VarCloner();

?>

@component('telescope-toolbar::item', ['name' => 'dump', 'link' => false])

    @slot('icon')
        @ttIcon('session')
        <span class="sf-toolbar-value sf-toolbar-info-piece-additional">Session</span>
    @endslot

    @slot('text')

        @if(isset($data['session']))
        <div class="sf-toolbar-info-piece">
            <div class="sf-toolbar-dump">

               {!!  $dumper->dump($varCloner->cloneVar($data['session'])) !!}

            </div>
        </div>
        @endif


    @endslot

@endcomponent
