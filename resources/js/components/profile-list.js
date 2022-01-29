import React, {useState} from 'react';
import ProfileListItem from './profile-list-item'

const ProfileList = props => {
	return (
		<div className="bg-white shadow overflow-hidden sm:rounded-md">
    	  <ul role="list" className="divide-y divide-gray-200">
    		{props.profiles.map(profile => <ProfileListItem key={profile.id} profile={profile} />)}
		  </ul>
		</div>
	)
}

export default ProfileList

