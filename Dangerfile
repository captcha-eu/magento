# cycle through each change
git.diff.each do |chunk|
	# filter changed->added
	chunk.patch.lines.grep(/^\+/).each do |added_line|
		# match strings
		if added_line.match(/\.krone\.at|todo|var_dump|print_r/i)
			fail "```\nForbidden/Sensitive Content occured '#{added_line.strip}'\n```"
		end
	end
end
