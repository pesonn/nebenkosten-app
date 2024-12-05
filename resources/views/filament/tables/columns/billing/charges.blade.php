<?php

?>

<p>
    {{ $getRecord()->locations()->where('location_id', $this->getOwnerRecord()->location->id)->first()?->pivot->amount}}
    €
</p>
