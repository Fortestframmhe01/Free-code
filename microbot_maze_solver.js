let path = []
let pathIndex = 0
let show = document.getElementById('show')

function IntersectionPath(direction) {
	path[pathIndex] = direction
  pathIndex++
}

/* 
	@ จำลองการวิ่งบนสนาม
*/
IntersectionPath('F')
IntersectionPath('R')
IntersectionPath('F')
IntersectionPath('L')
IntersectionPath('B')
IntersectionPath('L')
IntersectionPath('F')
IntersectionPath('R')
IntersectionPath('B')
IntersectionPath('R')
IntersectionPath('L')
IntersectionPath('R')
IntersectionPath('F')
IntersectionPath('E')

function pathOptimize() {
	if(path[pathIndex - 1] == 'E') {
  	return 'E'
    
  } else {
  	if(path[pathIndex - 1] == 'L') {
      return 'R'
    } else if(path[pathIndex - 1] == 'R') {
      return 'L'
    } else if(path[pathIndex - 1] == 'F') {
    	return 'F'
    } else if(path[pathIndex - 1] == 'B') {
      if(path[pathIndex - 2] == 'L') {
        return 'R'
      } else if(path[pathIndex - 2] == 'R') {
        return 'L'
     	} else if(path[pathIndex - 2] == 'F') {
      	return 'F'
      } else if(path[pathIndex - 2] == 'B') {
        if(path[pathIndex - 3] == 'L') {
          return 'R'
        } else if(path[pathIndex - 3] == 'R') {
          return 'L'
        } else if(path[pathIndex - 3] == 'F') {
        	return 'F'
        } else if(path[pathIndex - 3] == 'B') {
          if(path[pathIndex - 4] == 'L') {
            return 'R'
          } else if(path[pathIndex - 4] == 'R') {
            return 'L'
          } else if(path[pathIndex - 4] == 'F') {
          	return 'F'
          } else if(path[pathIndex - 4] == 'B') {
            if(path[pathIndex - 5] == 'L') {
              return 'R'
            } else if(path[pathIndex - 5] == 'R') {
              return 'L'
            } else if(path[pathIndex - 5] == 'F') {
            	return 'F'
            } else {
              return false;
            }
          }
        } 
      }
    }
  }
}


function setAIremember() {
	if(pathOptimize() == 'E') {
  	var Str = ''
  	for(let i = 0;i < path.length;i++) {
    	Str += path[i] + ' '
    }
    
    let StrConvert = Str.replace('L B ', '')
    StrConvert = StrConvert.replace('R B ', '')
    
    setCookie('AI_LINE', StrConvert, 1000000)
  }
}

function getLineTag() {
	let StrLine = getCookie('AI_LINE')
  let ArrayLine = StrLine.split(' ')
  
  for(let i = 0;i < ArrayLine.length;i++) {
  	switch(ArrayLine[i]) {
    	case 'L':
      	show.innerHTML += 'เลี้ยวซ้าย <br>'
      break;
      
      case 'R':
      	show.innerHTML += 'เลี้ยวขวา <br>'
      break;
      
      case 'E':
      	show.innerHTML += 'จุดจบ'
      break;
      
      case 'F':
      	show.innerHTML += 'เดินตรง <br>'
      break;
    }
  }
}

function setCookie(cname, cvalue, exdays) {
  let d = new Date()
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000))
  let expires = "expires=" + d.toUTCString()
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/"
}

function getCookie(cname) {
  let name = cname + '='
  let decodedCookie = decodeURIComponent(document.cookie)
  let ca = decodedCookie.split(';')
  for(let i = 0; i < ca.length; i++) {
    let c = ca[i]
    while (c.charAt(0) == ' ') {
      c = c.substring(1)
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length)
    }
  }
  return ''
}

setInterval(function() {
	if(getCookie('AI_LINE') != '' && show.textContent == '') {
    getLineTag()
  } else if(getCookie('AI_LINE') == '' && show.textContent != '') {
    setAIremember()
  }
}, 1000)
