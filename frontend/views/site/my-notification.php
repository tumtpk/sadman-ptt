<!DOCTYPE html>
<html>
  <head>
    <title>Vis Network | Basic usage</title>

    <script 
      type="text/javascript"
      src="https://visjs.github.io/vis-network/standalone/umd/vis-network.min.js"
    ></script>

    <style type="text/css">
      #mynetwork {
        width: 100%;
        height: 400px;
        border: 1px solid lightgray;
      }
    </style>
  </head>
  <body>
    <script>
        // create a DataSet
var options = {};
var data = new vis.DataSet(options);

// add items
// note that the data items can contain different properties and data formats
data.add([
  {id: 1, text: 'item 1', date: new Date(2013, 6, 20), group: 1, first: true},
  {id: 2, text: 'item 2', date: '2013-06-23', group: 2},
  {id: 3, text: 'item 3', date: '2013-06-25', group: 2},
  {id: 4, text: 'item 4'}
]);

// subscribe to any change in the DataSet
data.on('*', function (event, properties, senderId) {
  console.log('event', event, properties);
});

// update an existing item
data.updateOnly({id: 2, group: 1});

// remove an item
data.remove(4);

// get all ids
var ids = data.getIds();
console.log('ids', ids);

// get a specific item
var item1 = data.get(1);
console.log('item1', item1);

// retrieve a filtered subset of the data
var items = data.get({
  filter: function (item) {
    return item.group == 1;
  }
});
console.log('filtered items', items);

// retrieve formatted items
var items = data.get({
  fields: ['id', 'date'],
  type: {
    date: 'ISODate'
  }
});
console.log('formatted items', items);

    </script>
    
  </body>
</html>
