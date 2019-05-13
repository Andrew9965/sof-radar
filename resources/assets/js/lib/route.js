const _ = require('lodash')

export default {

    segmentPars () {
        let loc = window.location.hash.replace('#/', '')
        if (loc == '') return []
        else return loc.split('/')
    },

    getSegment ($position=false, $default=false) {
        let p = this.segmentPars()
        if (!p.length) return $default
        if (typeof $position == 'boolean' && !$position && ! $default) return p
        if (typeof $position == 'number' && p[$position] !== undefined) return p[$position]
        if (typeof $default != 'boolean') return $default
        return p
    },

    hasSegment ($name, $position=false) {
        let segments = this.getSegment()
        if (typeof $position == 'number' && $position){
            if (segments[$position] != undefined && segments[$position] == $name) return true
            else return false
        }
        let find = 0
        _.map(segments, (val, key) => {
            if(val == $name) find++
        })
        return find ? true : false
    },

    getClassName ($name='') {
        $name = $name.replace(/\_/g, ' ')
        let $return = $name.replace(/(?:^\w|[A-Z]|\b\w)/g, function(letter, index) {
            return index == 0 ? letter.toLowerCase() : letter.toUpperCase();
        }).replace(/\s+/g, '')+'Component'
        return $return
    },

    getSegmentClass ($name, $default, $position=0) {
        if (this.hasSegment($name, $position)) return this.getClassName(this.getSegment($position))
        else return this.getClassName($default)
    }
}

