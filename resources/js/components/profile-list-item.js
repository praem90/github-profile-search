import React from 'react';

export default (props) => {
	return (
    			<li onClick={props.onClick}>
      	  	  	  <a href="#" className="block hover:bg-gray-50">
        			<div className="flex items-center px-4 py-4 sm:px-6">
          	  	  	  <div className="min-w-0 flex-1 flex items-center">
            			<div className="flex-shrink-0">
              	  	  	  <img className="h-12 w-12 rounded-full" src={props.profile.avatar_url} alt="" />
            			</div>
            			<div className="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
              	  	  	  <div>
                			<h3 className="text-md font-medium text-gray-800 truncate">{props.profile.login}</h3>
              	  	  	  </div>
              	  	  	  <div className="flex items-center justify-end">
                  	  	  	  <p className="text-sm text-right text-gray-900">
        							Repo #<span>{props.profile.public_repos}</span>
                  	  	  	  </p>
              	  	  	  </div>
            			</div>
          	  	  	  </div>
          	  	  	  <div>
            			<svg className="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              	  	  	  <path fillRule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clipRule="evenodd" />
            			</svg>
          	  	  	  </div>
        			</div>
      	  	  	  </a>
    			</li>
	)
}
