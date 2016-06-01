<div class="test-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>



<todo>

    <!-- layout -->
    <h3>{ opts.title }</h3>

    <ul>
        <li each={ item, i in items }>{ item }</li>
    </ul>

    <form onsubmit={ add }>
        <input>
        <button>Add #{ items.length + 1 }</button>
    </form>

    <!-- style -->
    <style scoped>
        h3 {
            font-size: 14px;
        }
    </style>

    <!-- logic -->
    <script>
        this.items = []

        add(e) {
            var input = e.target[0]
            this.items.push(input.value)
            input.value = ''
        }
    </script>


    <?php $widget = \uworkru\riot\RiotTag::begin() ;  $widget->startTag='todo' ?>
        this.items = []

        add(e) {
            var input = e.target[0]
            this.items.push(input.value)
            input.value = ''
        }
    <?php \uworkru\riot\RiotTag::end() ?>

</todo>




<todo>
    <div each={ items }>
        <h3>{ title }</h3>
        <a onclick={ parent.remove }>Remove</a>
    </div>

    this.items = [ { title: 'First' }, { title: 'Second' } ]

    remove(event) {

    // looped item
    var item = event.item

    // index on the collection
    var index = this.items.indexOf(item)

    // remove from collection
    this.items.splice(index, 1)
    }
</todo>



<todo>
    <ul>
        <li each={ items } class={ completed: done }>
            <input type="checkbox" checked={ done }> { title }
        </li>
    </ul>

    this.items = [
    { title: 'First item', done: true },
    { title: 'Second item' },
    { title: 'Third item' }
    ]
</todo>

<Hr>


<!-- mount point -->
<my-tag></my-tag>

<!-- inlined tag definition -->
<script type="riot/tag">
  <my-tag>
    <h3>Tag layout</h3>
    <inner-tag />
  </my-tag>
</script>

<!-- <inner-tag/> is specified on external file -->
<script src="path/to/javascript/with-tags.js" type="riot/tag"></script>

<!-- include riot.js and the compiler -->
<script src="https://cdn.jsdelivr.net/riot/2.4/riot+compiler.min.js"></script>


<!-- mount normally -->
<script>
    riot.mount('*')
</script>




