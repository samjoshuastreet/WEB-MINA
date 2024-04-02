function nearestLine(currentLoc) {
var point = turf.point(currentLoc);
$.ajax({
url: '{{ route("paths.get") }}',
data: '',
success: (response) => {
const lineStrings = [];
var results = response.paths;
results.forEach(function(path, index) {
// Construct GeoJSON features for each LineString
const lineStringFeature = turf.lineString([
[path.wp_a_lng, path.wp_a_lat],
[path.wp_b_lng, path.wp_b_lat]
], {
id: path.id
});
lineStrings.push(lineStringFeature);
});

// let nearestLineString;
// let minDistance = Infinity;
// // Iterate through each LineString to find the nearest one
// lineStrings.forEach(lineString => {
// const distance = turf.pointToLineDistance(point, lineString, {
// units: 'meters'
// });

// // Update the nearest LineString if a closer one is found
// if (distance < minDistance) { // minDistance=distance; // nearestLineString=lineString; // } // }); let nearestLineStrings=[]; let distances=[]; // Iterate through each LineString to find the nearest ones lineStrings.forEach(lineString=> {
    const distance = turf.pointToLineDistance(point, lineString, {
    units: 'meters'
    });
    console.log(`line: ${lineString.properties.id}, distance: ${distance}`);

    // Add the distance and corresponding LineString to the arrays
    distances.push(distance);
    nearestLineStrings.push({
    lineString,
    distance
    });
    });

    // Sort the distances array to find the 3 smallest distances
    distances.sort((a, b) => a - b);

    // Extract the 3 nearest LineStrings
    const nearestLineStringIndices = distances.slice(0, 3).map(distance => distances.indexOf(distance));
    nearestLineStrings = nearestLineStringIndices.map(index => lineStrings[index]);

    nearestPointOnLine(currentLoc, nearestLineStrings);
    // console.log("Nearest LineString:", nearestLineString.properties.id);
    // console.log("Distance to Nearest LineString:", minDistance);
    },
    error: (error) => {
    console.log(error);
    }
    });
    // const {
    // nearestPointOnLine
    // } = turf;
    // line = turf.lineString(line);
    // pt = turf.point(pt);
    // var snapped = turf.nearestPointOnLine(line, pt, {
    // units: 'miles'
    // });
    // console.log(snapped.geometry.coordinates);
    // var coordinates = [snapped.geometry.coordinates[0], snapped.geometry.coordinates[1]];
    // var thisMarker = new mapboxgl.Marker()
    // .setLngLat(coordinates)
    // .addTo(map);
    }

    function nearestPointOnLine(currentLoc, nearestLines) {
    const {
    nearestPointOnLine
    } = turf;
    var nearestLineChampion = {
    line: null,
    dist: Infinity,
    point: null
    }
    var ajaxRequests = [];
    nearestLines.forEach(function(nearestLine) {
    var request = new Promise(function(resolve, reject) {
    $.ajax({
    url: '{{ route("paths.find") }}',
    data: {
    'id_search': true,
    'id': nearestLine.properties.id
    },
    success: (response) => {
    console.log(nearestLine.properties.id)
    var path = response.path;
    var point = turf.point(currentLoc);
    var tempLine = [
    [path.wp_a_lng, path.wp_a_lat],
    [path.wp_b_lng, path.wp_b_lat]
    ]
    var line = turf.lineString([
    [path.wp_a_lng, path.wp_a_lat],
    [path.wp_b_lng, path.wp_b_lat]
    ]);
    var snapped = turf.nearestPointOnLine(line, point, {
    units: 'meters'
    });
    if (snapped.properties.dist < nearestLineChampion.dist) { nearestLineChampion.line=nearestLine.properties.id; nearestLineChampion.dist=snapped.properties.dist; nearestLineChampion.point=snapped.geometry.coordinates; } console.log(nearestLineChampion); resolve(); }, error: (error)=> {
        reject(error);
        }
        });
        });
        ajaxRequests.push(request);
        });

        Promise.all(ajaxRequests).then(function() {
        // This code will execute after all AJAX requests are finished
        renderPath(currentLoc, nearestLineChampion.point, true);
        console.log(nearestLineChampion);
        }).catch(function(error) {
        console.log(error);
        });

        }