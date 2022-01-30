import React from 'react';

export default (props) => {
	return (
    			<li >
      	  	  	  <a href="#" className="block hover:bg-gray-50">
        			<div className="flex items-center px-4 py-4 sm:px-6">
          	  	  	  <div className="min-w-0 flex-1 flex items-center">
            			<div className="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
              	  	  	  <div>
                			<h3 className="text-md font-medium text-gray-800 truncate">{props.repo.name}</h3>
              	  	  	  </div>
              	  	  	  <div className="flex flex-col items-end justify-end">
    						<span className="mb-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
    							Starred {props.repo.stargazers_count}
    						</span>
    						<span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
    							Forks {props.repo.forks_count}
    						</span>
              	  	  	  </div>
            			</div>
          	  	  	  </div>
        			</div>
      	  	  	  </a>
    			</li>
	)
}

