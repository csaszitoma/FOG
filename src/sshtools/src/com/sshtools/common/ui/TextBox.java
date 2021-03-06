/*
 *  My3SP
 *
 *  Copyright (C) 2003 3SP LTD. All Rights Reserved
 *
 *  This program is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU General Public License
 *  as published by the Free Software Foundation; either version 2 of
 *  the License, or (at your option) any later version.
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public
 *  License along with this program; if not, write to the Free Software
 *  Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
 */
package com.sshtools.common.ui;

import javax.swing.*;

/**
 *  Description of the Class
 *
 *@author     magicthize
 *@created    26 May 2002
 */
public class TextBox extends JTextArea {
  private String text;

  public TextBox() {
    this("");
  }
  
  public TextBox(String text) {
    this(text, 0, 0);
  }
  
  public TextBox(String text, int rows, int columns) {
    super(rows, columns);
    setBackground(UIManager.getColor("Label.background"));
    setForeground(UIManager.getColor("Label.foreground"));
    setBorder(UIManager.getBorder("Label.border"));
    setFont(UIManager.getFont("TextField.font"));
	setOpaque(false);
	setWrapStyleWord(true);
	setLineWrap(true);
	setEditable(false);
	setText(text);
  }
}