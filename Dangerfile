# cycle through each change
git.diff.each do |chunk|
	# filter changed->added
	chunk.patch.lines.grep(/^+/).each do |added_line|
		# match strings
		if added_line.gsub!(
			/\.krone\.at/,
			/fixme/i,
			/todo/i,
			/var_dump/,
			/print_r/
			)
			fail "Forbidden/Sensitive Content occured '#{added_line}'"
		end
	end
end
